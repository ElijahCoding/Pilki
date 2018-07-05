<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployerWindow extends Model
{
    protected $fillable = [
        'employer_id',
        'service_category_id',
        'begin_at',
        'end_at',
        'schedule',
    ];

    protected $dates = [
        'begin_at',
        'end_at',
    ];

    protected $casts = [
        'schedule' => 'json',
    ];

    public function employer()
    {
      return $this->belongsTo(Employer::class);
    }

    public function serviceCategory()
    {
      return $this->belongsTo(ServiceCategory::class);
    }
}
