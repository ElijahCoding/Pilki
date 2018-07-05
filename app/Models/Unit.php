<?php

namespace App\Models;

use App\Models\Traits\Accessable;
use App\Models\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Unit
 *
 * @property integer $id
 * @property string $location_type
 * @property integer $location_id
 * @property integer $legal_entity_id
 * @property string $name
 * @property string $address
 * @property double $latitude
 * @property double $longitude
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Unit extends Model
{
    use Accessable;
    use Auditable;

    const ACCESS_UNIT_ID = 'id';
    const ACCESS_PARENT = LegalEntity::class;

    protected $fillable = [
        'location_type',
        'location_id',
        'legal_entity_id',
        'name',
        'address',
        'latitude',
        'longitude',
    ];

    protected $hidden = [
        'location_type',
        'location_id',
    ];

    protected $casts = [
        'latitude'  => 'float',
        'longitude' => 'float',
    ];

    public function location()
    {
        return $this->morphTo();
    }

    public function legalEntity()
    {
        return $this->belongsTo(LegalEntity::class);
    }

    public function unitGroups()
    {
        return $this->belongsToMany(UnitGroup::class, 'unit_rel_unit_groups')->withTimestamps();
    }

    public function employerPermissions()
    {
        return $this->morphMany(EmployerRelPermission::class, 'access');
    }

}
