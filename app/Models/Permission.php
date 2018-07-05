<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name',
    ];

    public function permissionGroups()
    {
        return $this->belongsToMany(PermissionGroup::class, 'permission_rel_permission_groups')->withTimestamps();
    }
}
