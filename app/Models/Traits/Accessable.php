<?php

namespace App\Models\Traits;

use Auth;
use App\Models\Employer;
use App\Models\Scopes\AllowedScope;
use App\Observers\AccessObserver;

trait Accessable
{

    /**
     * Boot the scope.
     *
     * @return void
     */
    public static function bootAccessable()
    {
        $user = Auth::user();
        if ($user instanceof Employer && !$user->is_superuser) {
            static::addGlobalScope(new AllowedScope());
            static::observe(new AccessObserver());
        }
    }

    /**
     * Get class name for access create check
     *
     * @return string
     */
    public function getAccessParent()
    {
        return defined('static::ACCESS_PARENT') ? static::ACCESS_PARENT : static::class;
    }

    /**
     * Get the name of the "unit_id" column.
     *
     * @return string
     */
    public function getAccessUnitIdColumn()
    {
        return defined('static::ACCESS_UNIT_ID') ? static::ACCESS_UNIT_ID : 'unit_id';
    }

    /**
     * Get the fully qualified "unit_id" column.
     *
     * @return string
     */
    public function getQualifiedAccessUnitId()
    {
        return $this->getAccessUnitIdColumn() ? $this->qualifyColumn($this->getAccessUnitIdColumn()) : null;
    }


    /**
     * Get the name of the "legal_entity_id" column.
     *
     * @return string
     */
    public function getAccessLegalEntityIdColumn()
    {
        return defined('static::ACCESS_LEGAL_ENTITY_ID') ? static::ACCESS_LEGAL_ENTITY_ID : 'legal_entity_id';
    }

    /**
     * Get the fully qualified "legal_entity_id" column.
     *
     * @return string
     */
    public function getQualifiedAccessLegalEntityId()
    {
        return $this->getAccessLegalEntityIdColumn() ? $this->qualifyColumn($this->getAccessLegalEntityIdColumn()) : null;
    }


    public function getCreatePermissionName()
    {
        return defined('static::PERMISSION_CREATE') ? static::PERMISSION_CREATE : 'create_child';
    }

    public function getUpdatePermissionName()
    {
        return defined('static::PERMISSION_UPDATE') ? static::PERMISSION_UPDATE : 'update';
    }

    public function getDeletePermissionName()
    {
        return defined('static::PERMISSION_DELETE') ? static::PERMISSION_DELETE : 'delete';
    }
}
