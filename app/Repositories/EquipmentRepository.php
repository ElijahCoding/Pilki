<?php

namespace App\Repositories;

use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Equipment;
use App\Validators\EquipmentValidator;

/**
 * Class EquipmentRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EquipmentRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'title' => 'like',
        'comment' => 'like',
    ];
    
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Equipment::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
