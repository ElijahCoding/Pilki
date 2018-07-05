<?php

namespace App\Models\Scopes;

use App\Repositories\PermissionRepository;
use Auth;
use App\Models\Employer;
use App\Models\Traits\Accessable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class AllowedScope implements Scope
{
    protected $user;
    protected $permissionRepository;

    public function __construct(Employer $user = null)
    {
        $this->permissionRepository = app(PermissionRepository::class);
        $this->user = is_null($user) ? Auth::user() : $user;
    }

    /**
     * Apply scope on the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model|Accessable $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $access = $this->permissionRepository->getAccess($this->user);

        if (
            (!isset($access['legalEntity'][get_class($model)]['view'])
                || $access['legalEntity'][get_class($model)]['view'] != '*')
            && (
                !isset($access['units'][get_class($model)]['view'])
                || $access['units'][get_class($model)]['view'] != '*'
            )
        ) {
            $builder->where(function (Builder $builder) use ($access, $model) {
                if ($legalEntityField = $model->getAccessLegalEntityIdColumn()) {
                    $builder->whereIn($legalEntityField, $access['legalEntity'][get_class($model)]['view'] ?? []);
                }

                if ($unitField = $model->getQualifiedAccessUnitId()) {
                    $builder->orWhereIn($unitField, $access['units'][get_class($model)]['view'] ?? []);
                }

                if ($model instanceof Employer) {
                    $builder->orWhere('id', $this->user->id);
                }
            });
        }
    }
}
