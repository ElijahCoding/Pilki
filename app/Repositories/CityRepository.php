<?php

namespace App\Repositories;

use App\Criteria\Request\PaginateCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\City;
use App\Validators\CityValidator;

/**
 * Class CityRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CityRepository extends BaseRepository
{

    protected $fieldSearchable = [
        'name' => 'like',
        'cityDistricts.name' => 'like',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return City::class;
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
