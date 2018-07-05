<?php


namespace App\Services;

use Socialite;
use App\Jobs\DownloadImage;
use App\Models\User;
use App\Models\UserSocial;

class AuthService
{
    /**
     * @param $provider
     * @return User
     */
    public function socialLogin($provider)
    {
        /** @var \Laravel\Socialite\Contracts\User $social */
        $social = Socialite::driver($provider)->user();

        $user = $this->getUserBySocial($provider, $social->getId());

        if (!$user) {

            $user = User::create([
                'name'   => $social->getName(),
                'status' => User::STATUS_FILL_FORM,
            ]);

            $user->userSocial()->save(new UserSocial([
                'provider'         => $provider,
                'provider_user_id' => $social->getId(),
            ]));

            dispatch(new DownloadImage(
                $user,
                'public',
                $social->getAvatar()
            ));
        }

        return $user;
    }

    /**
     * @param $provider
     * @param $providerUserId
     * @return User|null
     */
    public function getUserBySocial($provider, $providerUserId)
    {
        $userSocial = UserSocial::query()->where([
            'provider'         => $provider,
            'provider_user_id' => $providerUserId,
        ])->first();

        if (!$userSocial) {
            return null;
        }

        return $userSocial->user;
    }
}
