<?php

namespace App\Models;

use App\Models\Scopes\AllowedScope;
use App\Models\Traits\Accessable;
use App\Models\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class Employer
 *
 * @property integer $id
 * @property integer $schedule_type
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property boolean $is_superuser\
 * @property string $remember_token
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 * @method static Builder whereEmail($value)
 *
 * @package App\Models
 */
class Employer extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use Auditable;
    use Accessable;

    const STATUS_WORKED = 0;
    const STATUS_HIRED = 1;
    const STATUS_FIRED = 2;

    const SCHEDULE_TYPE_WINDOW_DEFAULT = 0;
    const SCHEDULE_TYPE_WINDOW_INDIVIDUAL = 1;

    const EDUCATION_HIGHER = 0;
    const EDUCATION_SECONDARY = 1;
    const EDUCATION_INCOMPLETE_HIGHER = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'work_position_id',
        'employer_category_id',
        'parent_employer_id',
        'metro_id',
        'first_name',
        'last_name',
        'middle_name',
        'school',
        'email',
        'phone',
        'password',
        'schedule_type',
        'is_superuser',
        'status',
        'education',
        'interview_at',
        'start_work_at',
        'remember_token',
        'remember_password',
    ];

    protected $casts = [
        'legal_entity_id' => 'integer',
        'schedule_type'   => 'integer',
        'is_superuser'    => 'boolean',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_password',
    ];

    /**
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_WORKED => __('Работает'),
            self::STATUS_HIRED  => __('Приглашен'),
            self::STATUS_FIRED  => __('Уволен'),
        ];
    }

    public static function getScheduleTypes()
    {
        return [
            self::SCHEDULE_TYPE_WINDOW_DEFAULT    => __('Обычные окна'),
            self::SCHEDULE_TYPE_WINDOW_INDIVIDUAL => __('Индивидуальные окна'),
        ];
    }

    public static function getEducations()
    {
        return [
            self::EDUCATION_HIGHER            => __('Высшее Образование'),
            self::EDUCATION_SECONDARY         => __('Среднее Образование'),
            self::EDUCATION_INCOMPLETE_HIGHER => __('Незаконченное Высшее Образование'),
        ];
    }

    public function permissions()
    {
        return $this->hasMany(EmployerRelPermission::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function legalEntity()
    {
        return $this->belongsTo(LegalEntity::class);
    }

    public function services()
    {
        return $this->morphedByMany(Service::class, 'service', 'employer_rel_services');
    }

    public function serviceCategories()
    {
        return $this->morphedByMany(ServiceCategory::class, 'service', 'employer_rel_services');
    }

    public function isLinkedToService()
    {
        return !! $this->services->where('employer_id', $this->id)->count();
    }

    public function isLinkedToServiceCategory()
    {
        return !! $this->serviceCategories->where('employer_id', $this->id)->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|EmployerSchedule[]
     */
    public function schedules()
    {
        return $this->hasMany(EmployerSchedule::class);//->where('begin_at', '>=', Carbon::now());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|WorkPosition
     */
    public function workPosition()
    {
        return $this->belongsTo(WorkPosition::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|EmployerCategory
     */
    public function employerCategory()
    {
        return $this->belongsTo(EmployerCategory::class);
    }


    public function metro()
    {
        return $this->hasOne(Metro::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
