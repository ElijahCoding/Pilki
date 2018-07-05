<?php

namespace App\Repositories;

use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\CityDistrict;
use App\Validators\CityDistrictValidator;

/**
 * Class CityDistrictRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CityDistrictRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CityDistrict::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
