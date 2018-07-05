<?php

namespace App\Repositories;

use App\Models\Metro;
use Prettus\Repository\Criteria\RequestCriteria;

class MetroRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name' => 'like'
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Metro::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
