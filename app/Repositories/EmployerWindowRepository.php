<?php

namespace App\Repositories;

use App\Models\EmployerWindow;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class TimeWindowRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EmployerWindowRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EmployerWindow::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
    }

}
