<?php

namespace App\Models;

use App\Models\Scopes\AllowedScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UnitGroup
 *
 * @property integer $id
 * @property string $name
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @package App\Models
 */
class UnitGroup extends Model
{
    protected $fillable = [
        'name',
    ];

    public function units()
    {
        return $this->belongsToMany(Unit::class,
            'unit_rel_unit_groups')->withTimestamps()->withoutGlobalScope(AllowedScope::class);
    }

    public function employerPermissions()
    {
        return $this->morphMany(EmployerRelPermission::class, 'access');
    }
}
