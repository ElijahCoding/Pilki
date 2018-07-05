<?php

namespace App\Models;

use App\Models\Traits\Accessable;
use App\Models\Traits\Auditable;
use App\Models\Traits\Imageable;
use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use Accessable;
    use Auditable;
    use Translatable;
    use Imageable;

    const ACCESS_UNIT_ID = null;

    protected $fillable = [
        'legal_entity_id',
        'service_category_id',
        'title',
        'title_online',
        'title_cashier',
        'article',
        'barcode',
        'duration',
    ];

    protected $casts = [
        'title'         => 'translate',
        'title_online'  => 'translate',
        'title_cashier' => 'translate',
    ];

    protected $hidden = [
        'pivot',
    ];

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function serviceResource()
    {
        return $this->hasMany(ServiceResource::class);
    }

    public function servicePrice()
    {
        return $this->hasMany(ServicePrice::class);
    }
}
