<?php

namespace App\Repositories;

use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\ServiceResource;
use App\Validators\ServiceResourceValidator;

/**
 * Class ServiceResourceRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ServiceResourceRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ServiceResource::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
