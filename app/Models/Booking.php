<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'employer_window_id', 'user_id'
    ];

    public function employerWindow()
    {
      return $this->belongsTo(EmployerWindow::class);
    }
}
