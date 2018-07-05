<?php

namespace App\Models;

use App\Models\Traits\Accessable;
use App\Models\Traits\Auditable;
use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use Translatable;
    use Auditable;
    use Accessable;

    const ACCESS_UNIT_ID = null;

    protected $fillable = [
        'legal_entity_id',
        'title',
    ];

    protected $casts = [
        'legal_entity_id' => 'integer',
        'title'           => 'translate',
    ];

    protected $hidden = [
        'pivot',
    ];

    public function legalEntity()
    {
        return $this->hasOne(LegalEntity::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

}
