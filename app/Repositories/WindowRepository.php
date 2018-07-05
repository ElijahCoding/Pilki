<?php

namespace App\Repositories;

use App\Models\Window;

/**
 * Class EquipmentRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WindowRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Window::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
    }

}
