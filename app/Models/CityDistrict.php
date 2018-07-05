<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class CityDistrict extends Model
{
    use Translatable;

    protected $fillable = [
        'name',
        'city_id',
    ];

    public function city()
    {
      return $this->belongsTo(City::class);
    }
}
