<?php


namespace App\Http\Controllers\Users;


use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Auth\SocialFillFormRequest;
use App\Models\User;
use App\Models\UserSocial;
use App\Services\AuthService;
use Auth;
use Illuminate\Http\Request;
use Socialite;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthController extends Controller
{

    public function login()
    {
        return view('users.auth.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('users.index');
    }

    public function register()
    {

    }

    public function passwordRequest()
    {

    }

    public function passwordReset()
    {

    }

    /**
     * Redirect to social
     *
     * @param $provider
     *
     * @return mixed
     */
    public function socialRedirect($provider)
    {
        if (!in_array($provider, UserSocial::$allowed)) {
            throw new NotFoundHttpException();
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Social callback
     *
     * @param $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function socialCallback(AuthService $authService, $provider)
    {
        if (!in_array($provider, UserSocial::$allowed)) {
            throw new NotFoundHttpException();
        }

        $user = $authService->socialLogin($provider);

        if ($user->status === User::STATUS_FILL_FORM) {
            session(['user_id' => $user->id]);
            return redirect()->route('users.auth.social.fill_form');
        }

        Auth::login($user);

        return redirect()->route('users.index');
    }

    /**
     * Filling additional info after social register
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function socialFillForm()
    {
        return view('users.auth.social_fill_form');
    }

    /**
     * Save form and login
     *
     * @param SocialFillFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function socialFillFormSave(SocialFillFormRequest $request)
    {
        $user = User::find(session('user_id'));

        $user->phone = $request->phone;
        $user->email = $request->email;

        $user->save();

        Auth::login($user);

        return redirect()->route('users.index');
    }

}