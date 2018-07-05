<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use Translatable;

    protected $fillable = [
        'region_id',
        'name',
    ];

    protected $casts = [
        'name' => 'translate',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function cityDistricts()
    {
        return $this->hasMany(CityDistrict::class);
    }

    public function metros()
    {
        return $this->hasMany(Metro::class);
    }
}
