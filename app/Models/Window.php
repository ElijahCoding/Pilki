<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Window extends Model
{
    protected $fillable = [
        'unit_id',
        'employer_id',
        'equipment_id',
        'booking_id',
        'begin_at',
        'end_at',
        'duration_original',
        'duration',
    ];

    protected $dates = [
        'begin_at',
        'end_at',
    ];

    public function unit()
    {
      return $this->belongsTo(Unit::class);
    }

    public function employer()
    {
      return $this->belongsTo(Employer::class);
    }

    public function equipment()
    {
      return $this->belongsTo(Equipment::class);
    }

    public function booking()
    {
      return $this->belongsTo(Booking::class);
    }
}
