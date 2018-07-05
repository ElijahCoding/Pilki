<?php

namespace App\Repositories;

use App\Models\WorkPositionRelService;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class WorkPositionServiceRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WorkPositionServiceRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WorkPositionRelService::class;
    }
}
