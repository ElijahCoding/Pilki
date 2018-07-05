<?php

namespace App\Repositories;

use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\LegalEntity;
use App\Validators\LegalEntityValidator;

/**
 * Class LegalEntityRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class LegalEntityRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LegalEntity::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
