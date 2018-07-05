<?php

namespace App\Repositories;

use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Region;
use App\Validators\RegionValidator;

/**
 * Class RegionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RegionRepository extends BaseRepository
{

    protected $fieldSearchable = [
        'name'  => 'like',
        'cities.name' => 'like',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Region::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
