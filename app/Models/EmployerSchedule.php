<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class EmployerSchedule.
 *
 * @property integer $id
 * @property integer|null $unit_id
 * @property integer $employer_id
 * @property integer $equipment_id
 * @property Carbon $begin_at
 * @property Carbon $end_at
 * @property integer $status
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 * @package namespace App\Models;
 */
class EmployerSchedule extends Model implements Transformable
{
    use TransformableTrait;

    const STATUS_NEW = 0;
    const STATUS_APPROVED = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unit_id',
        'employer_id',
        'equipment_id',
        'begin_at',
        'end_at',
        'status',
    ];

    protected $dates = [
        'begin_at',
        'end_at',
    ];

    public static function getStatuses()
    {
        return [
            self::STATUS_NEW      => __('Новый'),
            self::STATUS_APPROVED => __('Одобрен'),
        ];
    }

    /**
     * @return Employer|BelongsTo
     */
    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    /**
     * @return Equipment|null|BelongsTo
     */
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

}
