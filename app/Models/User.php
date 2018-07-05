<?php

namespace App\Models;

use App\Models\Contracts\IImageable;
use App\Models\Traits\Imageable;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $password
 * @property integer $status
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 * @package App\Models
 */
class User extends Authenticatable implements IImageable, JWTSubject
{
    use Notifiable, Imageable;

    const STATUS_ENABLED = 0;
    const STATUS_FILL_FORM = 1;
    const STATUS_DISABLED = 2;
    const STATUS_BAN = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];


    public function userSocial()
    {
        return $this->hasMany(UserSocial::class);
    }

    public function getRememberTokenName()
    {
        return null; // not supported
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

   // example function for UserTransformer
   public function avatar()
   {
       return 'https://www.gravatar.com/avatar/' . md5($this->email) . '?s=45&d=mm';
   }
}
