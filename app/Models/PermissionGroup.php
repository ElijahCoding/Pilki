<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_rel_permission_groups')->withTimestamps();
    }
}
