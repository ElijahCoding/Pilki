<?php

namespace App\Models;

use App\Models\Scopes\AllowedScope;
use App\Models\Traits\Accessable;
use App\Models\Traits\Auditable;
use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class WorkPosition.
 *
 * @package namespace App\Models;
 */
class WorkPosition extends Model implements Transformable
{
    use Accessable;
    use Auditable;
    use Translatable;
    use TransformableTrait;

    const ACCESS_UNIT_ID = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'legal_entity_id'
    ];

    public function permissions()
    {
        return $this->hasMany(WorkPositionRelPermission::class)->withoutGlobalScope(AllowedScope::class);
    }

    public function service()
    {
        return $this->hasMany(WorkPositionRelService::class)->withoutGlobalScope(AllowedScope::class);
    }
}
