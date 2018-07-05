<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
 *
 * @property integer $id
 * @property string $name
 * @property string $currency
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @package App\Models
 */
class Country extends Model
{
    use Translatable;

    protected $fillable = [
        'name',
        'currency',
    ];

    protected $casts = [
        'name' => 'translate',
    ];

    public function regions()
    {
        return $this->hasMany(Region::class);
    }
}
