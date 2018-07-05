<?php

namespace App\Repositories;

use App\Criteria\Request\PaginateCriteria;
use App\Helpers\CacheKeys;
use App\Models\EmployerRelPermission;
use App\Models\WorkPosition;
use Cache;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Employer;
use App\Validators\EmployerValidator;

/**
 * Class EmployerRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EmployerRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'first_name'         => 'like',
        'middle_name'        => 'like',
        'last_name'          => 'like',
        'phone'              => 'like',
        'email'              => 'like',
        'schedules.begin_at' => '>=',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Employer::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(PaginateCriteria::class));
    }

    public function create(array $attributes)
    {
        /** @var Employer $employer */
        $employer = parent::create($attributes);

        $this->setWorkPosition($employer->id, $attributes['work_position_id']);

        return $employer;
    }

    public function update(array $attributes, $id)
    {
        /** @var Employer $employer */
        $employer = parent::update($attributes, $id);

        if ($employer->isDirty('work_position_id')) {
            $this->setWorkPosition($employer->id, $attributes['work_position_id']);
        }

        return $employer;
    }

    /**
     * Set work position
     *
     * @param $employerId
     * @param $workPositionId
     */
    public function setWorkPosition($employerId, $workPositionId)
    {
        $this->find($employerId)->update([
            'work_position_id' => $workPositionId,
        ]);

        EmployerRelPermission::updateOrCreate([
            'permission_type' => WorkPosition::class,
            'permission_id'   => $workPositionId,
        ], [
            'permission_id' => $workPositionId,
        ]);

        Cache::tags(['permissions'])->forget(CacheKeys::PERMISSION_EMPLOYER_KEY . $employerId);
    }


}
