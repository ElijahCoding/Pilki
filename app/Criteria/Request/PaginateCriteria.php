<?php

namespace App\Criteria\Request;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class PaginateCriteria.
 *
 * Request pagination for repository. Request params: limit, offset
 *
 * @package namespace App\Criteria;
 */
class PaginateCriteria implements CriteriaInterface
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply criteria in query repository
     *
     * @param Builder|Model $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if ($this->request->has('offset')) {
            $model = $model->offset($this->request->get('offset'));
        }

        if ($this->request->has('limit')) {
            $model = $model->limit($this->request->get('limit'));
        }

        return $model;
    }
}
