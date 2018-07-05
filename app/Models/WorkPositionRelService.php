<?php

namespace App\Models;

use App\Models\Scopes\AllowedScope;
use Illuminate\Database\Eloquent\Model;

class WorkPositionRelService extends Model
{
    protected $fillable = [
        'work_position_id',
        'service_type',
        'service_id',
    ];

    public function workPosition()
    {
        return $this->belongsTo(WorkPosition::class);
    }

    public function service()
    {
        return $this->morphTo()->withoutGlobalScope(AllowedScope::class);
    }
}
