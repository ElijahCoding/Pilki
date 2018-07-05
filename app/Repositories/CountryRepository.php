<?php

namespace App\Repositories;

use App\Models\Country;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class CountryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CountryRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name' => 'like',
        'region.name' => 'like',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Country::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
