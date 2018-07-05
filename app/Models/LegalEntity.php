<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LegalEntity
 *
 * @property integer $id
 * @property string $name
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @package App\Models
 */
class LegalEntity extends Model
{
    protected $fillable = [
        'name'
    ];

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function employerPermissions(){
        return $this->morphMany(EmployerRelPermission::class, 'access');
    }
}
