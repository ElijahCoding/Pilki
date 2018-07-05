<?php

namespace App\Models;

use App\Models\Traits\Accessable;
use App\Models\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class EmployerCategory extends Model
{
    use Accessable;
    use Auditable;

    const ACCESS_UNIT_ID = null;

    protected $fillable = [
        'legal_entity_id',
        'title',
        'aliases',
    ];

    protected $casts = [
        'aliases' => 'json',
    ];
}
