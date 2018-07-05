<?php

namespace App\Criteria\Api\Crm;

use App\Models\Employer;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class EmployerCriteria.
 *
 * @package namespace App\Criteria\Api\Crm;
 */
class EmployerCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param Employer $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->with([
            'unit',
            'unit.location',
            'legalEntity',
            'workPosition',
            'services:service_id'
        ]);

        return $model;
    }

}
