<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EquipmentWindow
 *
 * @property integer $id
 * @property integer $equipment_id
 * @property Carbon $begin_at
 * @property array $schedule
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 * @package App\Models
 */
class EquipmentWindow extends Model
{
    protected $fillable = [
        'equipment_id',
        'begin_at',
        'schedule',
    ];

    protected $dates = [
        'begin_at',
    ];

    protected $casts = [
        'schedule' => 'json',
    ];


    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }


}
