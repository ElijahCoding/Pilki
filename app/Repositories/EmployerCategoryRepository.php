<?php

namespace App\Repositories;

use App\Models\EmployerCategory;
use Prettus\Repository\Criteria\RequestCriteria;

class EmployerCategoryRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EmployerCategory::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
    }
    
}
