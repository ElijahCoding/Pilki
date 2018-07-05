<?php

namespace App\Repositories;

use App\Criteria\Request\PaginateCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Service;
use App\Validators\ServiceValidator;

/**
 * Class ServiceRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ServiceRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'legal_entity_id' => '=',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Service::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(PaginateCriteria::class));
    }
    
}
