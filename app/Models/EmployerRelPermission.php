<?php

namespace App\Models;

use App\Models\Scopes\AllowedScope;
use Illuminate\Database\Eloquent\Model;

class EmployerRelPermission extends Model
{
    protected $fillable = [
        'employer_id',
        'permission_type',
        'permission_id',
        'access_type',
        'access_id',
        'work_position_id',
        'date_from',
        'date_to',
    ];

    protected $with = [
        'access',
    ];

    public static $accessTypes = [
        \App\Models\Unit::class,
        \App\Models\UnitGroup::class,
        \App\Models\LegalEntity::class,
    ];

    public function access()
    {
        return $this->morphTo()->withoutGlobalScope(AllowedScope::class);
    }

    public function permission()
    {
        return $this->morphTo()->withoutGlobalScope(AllowedScope::class);
    }



}
