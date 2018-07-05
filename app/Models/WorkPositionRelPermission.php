<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkPositionRelPermission extends Model
{
    protected $fillable = [
        'work_position_id',
    ];

    public function workPosition()
    {
        return $this->belongsTo(WorkPosition::class);
    }

    public function permission()
    {
        return $this->morphTo();
    }
}
