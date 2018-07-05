<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserSocial
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $provider
 * @property string $provider_user_id
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 * @property User $user
 *
 * @package App\Models
 */
class UserSocial extends Model
{

    const PROVIDER_VKONTAKTE = 'vkontakte';
    const PROVIDER_GOOGLE = 'google';
    const PROVIDER_TWITTER = 'twitter';
    const PROVIDER_INSTAGRAM = 'instagram';
    const PROVIDER_FACEBOOK = 'faceboook';

    public static $allowed = [
        self::PROVIDER_VKONTAKTE,
    ];

    protected $fillable = [
        'user_id',
        'provider',
        'provider_user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
