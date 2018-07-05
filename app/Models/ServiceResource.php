<?php

namespace App\Models;

use App\Models\Traits\Accessable;
use App\Models\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class ServiceResource extends Model
{
    use Auditable;
    use Accessable;

    const ACCESS_UNIT_ID = null;

    protected $fillable = [
        'service_id',
        'legal_entity_id',
        'type',
        'count',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
