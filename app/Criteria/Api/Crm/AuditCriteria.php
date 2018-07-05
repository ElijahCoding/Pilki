<?php

namespace App\Criteria\Api\Crm;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class AuditCriteria.
 *
 * @package namespace App\Criteria;
 */
class AuditCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->with([
            'user',
            'model',
        ]);
    }
}
