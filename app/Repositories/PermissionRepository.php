<?php

namespace App\Repositories;

use App\Helpers\CacheKeys;
use App\Models\Employer;
use App\Models\EmployerRelPermission;
use App\Models\LegalEntity;
use App\Models\PermissionGroup;
use App\Models\Unit;
use App\Models\UnitGroup;
use App\Models\WorkPosition;
use Cache;
use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Container\Container as Application;

/**
 * Class PermissionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PermissionRepository extends BaseRepository
{

    protected $accesses = [];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Permission::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
    }


    /**
     * Get access ids
     *
     * DON'T MODIFY WITHOUT APPROVE FROM TEAM LEAD!!! MAYBE NEED REFACTORING
     *
     * Return fields
     * array['units']
     * array['legalEntity']
     *
     * @param Employer $employer
     * @return array
     */
    public function getAccess(Employer $employer)
    {
        if (isset($this->accesses[$employer->id])) {
            return $this->accesses[$employer->id];
        }

        return Cache::tags(['permissions'])->remember(CacheKeys::PERMISSION_EMPLOYER_KEY . $employer->id,
            CacheKeys::PERMISSION_EMPLOYER_TTL,
            function () use ($employer) {
                $employer->load([
                    'permissions',
                    'permissions.permission',
                ]);

                $units = [];
                $unitGroups = [];
                $legalEntity = [];

                foreach ($employer->permissions as $employerRelPermission) {
                    /** @var EmployerRelPermission $employerRelPermission */

                    if (is_null($employerRelPermission->permission)) {
                        continue;
                    }

                    $permissionMap = [];
                    switch (get_class($employerRelPermission->permission)) {
                        case Permission::class:
                            if (!isset($permissionMap[$employerRelPermission->permission->id])) {
                                $permissionMap[$employerRelPermission->permission->id] = [
                                    $employerRelPermission->permission->model,
                                    $employerRelPermission->permission->action,
                                ];
                            }
                            break;
                        case PermissionGroup::class:
                            foreach ($employerRelPermission->permission->permissions as $permissionFromGroup) {
                                if (!isset($permissionMap[$permissionFromGroup->id])) {
                                    $permissionMap[$permissionFromGroup->id] = [
                                        $permissionFromGroup->model,
                                        $permissionFromGroup->action,
                                    ];
                                }
                            }
                            break;
                        case WorkPosition::class:
                            $employerRelPermission->permission->load([
                                'permissions',
                                'permissions.permission',
                            ]);
                            foreach ($employerRelPermission->permission->permissions as $workPositionPermission) {
                                switch (get_class($workPositionPermission->permission)) {
                                    case Permission::class:
                                        if (!isset($permissionMap[$workPositionPermission->permission->id])) {
                                            $permissionMap[$workPositionPermission->permission->id] = [
                                                $workPositionPermission->permission->model,
                                                $workPositionPermission->permission->action,
                                            ];
                                        }
                                        break;
                                    case PermissionGroup::class:
                                        foreach ($workPositionPermission->permission->permissions as $permissionFromGroup) {
                                            if (!isset($permissionMap[$permissionFromGroup->id])) {
                                                $permissionMap[$permissionFromGroup->id] = [
                                                    $permissionFromGroup->model,
                                                    $permissionFromGroup->action,
                                                ];
                                            }
                                        }
                                        break;
                                }
                            }
                            break;
                    }


                    switch ($employerRelPermission->access_type) {
                        case UnitGroup::class:
                            foreach ($permissionMap as $permissionItem) {
                                $unitGroups[$employerRelPermission->access_id][$permissionItem[0]][$permissionItem[1]] = true;
                            }
                            break;
                        case LegalEntity::class:
                            foreach ($permissionMap as $permissionItem) {
                                if (is_null($employerRelPermission->access_id)) {
                                    $legalEntity[$permissionItem[0]][$permissionItem[1]] = '*';
                                    break;
                                }
                                if (
                                    isset($legalEntity[$permissionItem[0]][$permissionItem[1]])
                                    && $legalEntity[$permissionItem[0]][$permissionItem[1]] == '*'
                                ) {
                                    break;
                                }

                                if (isset($legalEntity[$permissionItem[0]][$permissionItem[1]])
                                    && !in_array($employerRelPermission->access_id,
                                        $legalEntity[$permissionItem[0]][$permissionItem[1]])) {
                                    $legalEntity[$permissionItem[0]][$permissionItem[1]][] = $employerRelPermission->access_id;
                                } else {
                                    $legalEntity[$permissionItem[0]][$permissionItem[1]] = [$employerRelPermission->access_id];
                                }
                            }
                            break;
                        case Unit::class:
                            foreach ($permissionMap as $permissionItem) {
                                if (is_null($employerRelPermission->access_id)) {
                                    $units[$permissionItem[0]][$permissionItem[1]] = '*';
                                    break;
                                }
                                if (
                                    isset($units[$permissionItem[0]][$permissionItem[1]])
                                    && $units[$permissionItem[0]][$permissionItem[1]] == '*'
                                ) {
                                    break;
                                }

                                if (isset($units[$permissionItem[0]][$permissionItem[1]])
                                    && !in_array($employerRelPermission->access_id,
                                        $units[$permissionItem[0]][$permissionItem[1]])) {
                                    $units[$permissionItem[0]][$permissionItem[1]][] = $employerRelPermission->access_id;
                                } else {
                                    $units[$permissionItem[0]][$permissionItem[1]] = [$employerRelPermission->access_id];
                                }
                            }
                            break;
                    }
                }

                if ($unitGroups) {
                    foreach (UnitGroup::whereIn('id', array_keys($unitGroups))->with('units')->get() as $unitGroup) {
                        foreach ($unitGroup->units as $unit) {
                            foreach ($unitGroups[$unitGroup->id] as $model => $modelActions) {
                                foreach ($modelActions as $modelAction => $tmp) {
                                    if (
                                        isset($units[$model][$modelAction])
                                        && $units[$model][$modelAction] == '*'
                                    ) {
                                        continue;
                                    }
                                    if (
                                        isset($units[$model][$modelAction])
                                        && !in_array($unit->id, $units[$model][$modelAction])
                                    ) {
                                        $units[$model][$modelAction][] = $unit->id;
                                    } else {
                                        $units[$model][$modelAction] = [$unit->id];
                                    }

                                }
                            }
                        }
                    }
                }

                $this->accesses[$employer->id] = [
                    'units'       => $units,
                    'legalEntity' => $legalEntity,
                ];

                return $this->accesses[$employer->id];
            });
    }

    public function checkByUnitId(Employer $employer, $model, $permissionName, $unitId)
    {
        if ($employer->is_superuser) {
            return true;
        }

        $access = $this->getAccess($employer);
//dd($access);
        return
            isset($access['units'][$model])
            && isset($access['units'][$model][$permissionName])
            && in_array($unitId, $access['units'][$model][$permissionName]);
    }

    /**
     * Saving permissions
     *
     * @param Employer $employer
     * @param string $accessType
     * @param integer $accessId
     * @param string $permissionType
     * @param integer $permissionId
     *
     * @param Carbon|null $dateFrom
     * @param Carbon|null $dateTo
     * @return array
     */
    public function savePermission(
        Employer $employer,
        $accessType,
        $accessId,
        $permissionType,
        $permissionId,
        $dateFrom = null,
        $dateTo = null
    ) {
        $employer->permissions()->updateOrCreate([
            'access_type'     => $accessType,
            'access_id'       => $accessId,
            'permission_type' => $permissionType,
            'permission_id'   => $permissionId,
            'date_from'       => $dateFrom,
            'date_to'         => $dateTo,
        ]);

        Cache::tags(['permissions'])->forget(CacheKeys::PERMISSION_EMPLOYER_KEY . $employer->id);

        return $this->getAccess($employer);
    }

    /**
     * Get all permissions for model
     *
     * @param string $modelName
     * @return \Illuminate\Support\Collection
     */
    public function getModelPermissions($modelName)
    {
        return Permission::query()
            ->where('model', $modelName)
            ->get(['id', 'action'])
            ->pluck('id', 'action');
    }

    public function getPermissions()
    {
        return $this->all(['id', 'model', 'action', 'description']);
    }

}
