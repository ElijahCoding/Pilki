<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use Translatable;

    protected $fillable = [
        'country_id',
        'name',
    ];

    protected $casts = [
        'name' => 'translate',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
