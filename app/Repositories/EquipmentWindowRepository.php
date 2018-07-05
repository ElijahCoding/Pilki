<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\EquipmentWindow;

/**
 * Class TimeWindowRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EquipmentWindowRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EquipmentWindow::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
    }
    
}
