<?php

namespace App\Repositories;

use App\Models\PermissionGroup;

/**
 * Class PermissionGroupRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PermissionGroupRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PermissionGroup::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
    }
    
}
