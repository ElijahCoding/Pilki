<?php

namespace App\Repositories;

use App\Criteria\Api\Crm\AuditCriteria;
use App\Criteria\Request\PaginateCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Audit;

/**
 * Class AuditRepository.
 *
 * @package namespace App\Repositories;
 */
class AuditRepository extends BaseRepository
{
    protected $fieldSearchable = [

    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Audit::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(AuditCriteria::class));
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(PaginateCriteria::class));
    }

}
