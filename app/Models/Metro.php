<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Metro extends Model
{
    use Translatable;

    protected $fillable = [
        'name',
        'city_id',
    ];

    protected $casts = [
        'name' => 'translate',
    ];

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
