<?php

namespace App\Repositories;

use App\Criteria\Request\PaginateCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\WorkPosition;

/**
 * Class WorkPositionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WorkPositionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'title' => 'like'
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WorkPosition::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(PaginateCriteria::class));
    }

    /**
     * Remove relation between (work position) and (service or service repository)
     */
    public function remove()
    {

    }
}
