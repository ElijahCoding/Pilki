<?php

namespace App\Models;

use App\Models\Traits\Accessable;
use App\Models\Traits\Auditable;
use App\Models\EquipmentType;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use Accessable;
    use Auditable;

    const STATUS_ENABLED = 0;
    const STATUS_DISABLED = 1;
    const STATUS_REPAIR = 2;

    protected $fillable = [
        'unit_id',
        'legal_entity_id',
        'title',
        'comment',
        'status',
    ];

    public static function getStatuses()
    {
        return [
            self::STATUS_ENABLED  => __('Включен'),
            self::STATUS_REPAIR   => __('В ремонте'),
            self::STATUS_DISABLED => __('Выключен'),
        ];
    }

    public function equipmentWindows()
    {
        return $this->hasMany(EquipmentWindow::class);
    }

    public function services()
    {
        return $this
            ->morphedByMany(Service::class, 'service', 'equipment_rel_services');
    }

    public function serviceCategories()
    {
        return $this
            ->morphedByMany(ServiceCategory::class, 'service', 'equipment_rel_services');
    }

}
