<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Booking;
use App\Validators\BookingValidator;

/**
 * Class BookingRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BookingRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Booking::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
    }

}
