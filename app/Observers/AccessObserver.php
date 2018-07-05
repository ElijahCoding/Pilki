<?php


namespace App\Observers;


use App\Models\Employer;
use App\Models\Traits\Accessable;
use App\Repositories\PermissionRepository;
use Auth;
use Illuminate\Database\Eloquent\Model;

class AccessObserver
{
    public $user;
    public $access;

    /**
     * AccessObserver constructor.
     * @param Employer|null $user
     */
    public function __construct($user = null)
    {
        $this->user = is_null($user) ? Auth::user() : $user;
        $this->access = app(PermissionRepository::class)->getAccess($this->user);
    }

    /**
     * Check create access (via parent)
     *
     * @param Model|Accessable $model
     * @return bool
     */
    public function creating($model)
    {

        return
            (
                isset($this->access['units'][$model->getAccessParent()][$model->getCreatePermissionName()])
                && (
                    $this->access['units'][$model->getAccessParent()][$model->getCreatePermissionName()] == '*'
                    || in_array($model->{$model->getAccessUnitIdColumn()},
                        $this->access['units'][$model->getAccessParent()][$model->getCreatePermissionName()])
                )
            ) || (
                isset($this->access['legalEntity'][$model->getAccessParent()][$model->getCreatePermissionName()])
                && (
                    $this->access['legalEntity'][$model->getAccessParent()][$model->getCreatePermissionName()] == '*'
                    || in_array($model->{$model->getAccessLegalEntityIdColumn()},
                        $this->access['legalEntity'][$model->getAccessParent()][$model->getCreatePermissionName()])
                )
            );
    }


    /**
     * Check update access
     *
     * @param Model|Accessable $model
     * @return bool
     */
    public function saving($model)
    {
        return (
                isset($this->access['units'][get_class($model)][$model->getUpdatePermissionName()])
                && (
                    $this->access['units'][get_class($model)][$model->getUpdatePermissionName()] == '*'
                    || in_array($model->{$model->getAccessUnitIdColumn()},
                        $this->access['units'][get_class($model)][$model->getUpdatePermissionName()])
                )
            ) || (
                isset($this->access['legalEntity'][get_class($model)][$model->getUpdatePermissionName()])
                && (
                    $this->access['legalEntity'][get_class($model)][$model->getUpdatePermissionName()] == '*'
                    || in_array($model->{$model->getAccessLegalEntityIdColumn()},
                        $this->access['legalEntity'][get_class($model)][$model->getUpdatePermissionName()])
                )
            );
    }

    /**
     * Check delete access
     *
     * @param Model|Accessable $model
     * @return bool
     */
    public function deleting($model)
    {
        return (
                isset($this->access['units'][get_class($model)][$model->getDeletePermissionName()])
                && (
                    $this->access['units'][get_class($model)][$model->getDeletePermissionName()] == '*'
                    || in_array($model->{$model->getAccessUnitIdColumn()},
                        $this->access['units'][get_class($model)][$model->getDeletePermissionName()])
                )
            ) || (
                isset($this->access['legalEntity'][get_class($model)][$model->getDeletePermissionName()])
                && (
                    $this->access['legalEntity'][get_class($model)][$model->getDeletePermissionName()] == '*'
                    || in_array($model->{$model->getAccessLegalEntityIdColumn()},
                        $this->access['legalEntity'][get_class($model)][$model->getDeletePermissionName()])
                )
            );
    }
}