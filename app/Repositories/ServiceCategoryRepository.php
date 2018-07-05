<?php

namespace App\Repositories;

use App\Criteria\Request\PaginateCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\ServiceCategory;
use App\Validators\ServiceCategoryValidator;

/**
 * Class ServiceCategoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ServiceCategoryRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'title'           => 'like',
        'legal_entity_id' => '=',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ServiceCategory::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(PaginateCriteria::class));
    }

}
