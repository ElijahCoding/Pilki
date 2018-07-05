<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePrice extends Model
{
    protected $fillable = [
        'service_id',
        'price',
        'used_at',
    ];

    protected $dates = [
        'used_at',
    ];

    public function service(){
        return $this->belongsTo(Service::class);
    }
}
