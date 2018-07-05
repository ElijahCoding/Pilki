<?php


namespace App\Models\Traits;

use App\Models\Audit;
use App\Models\Employer;
use App\Observers\AuditObserver;

/**
 * Trait Auditable
 *
 *
 * @package App\Models\Traits
 */
trait Auditable
{

    /**
     * Scope boot
     */
    public static function bootAuditable()
    {
        if (!\App::runningInConsole()) {
            static::observe(new AuditObserver);
        }
    }

    public function getAuditExcludes()
    {
        return $this->auditExcludes ?? [];
    }

    public function audits()
    {
        $this->morphMany(Audit::class, 'model');
    }
}