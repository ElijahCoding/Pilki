<?php

namespace App\Http\Controllers\Api\Users;

use App\Exceptions\Api\AttemptFailedException;
use App\Exceptions\ApiException;
//use App\Http\Requests\Api\PhoneConfirmRequest;
use App\Http\Requests\Api\Users\AuthRequest;
use App\Http\Requests\Api\Users\SocialAuthRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSocial;
use GuzzleHttp\Exception\ClientException;
use App\Exceptions\Api\SocialAuthorizationException;
use App\Exceptions\Api\AuthorizationException;
use App\Services\AuthService;
use JWTFactory;
use JWTAuth;
use Socialite;

/**
 * Class AuthController
 * @package App\Http\Controllers\Api\Users
 */
class AuthController extends Controller
{
    /**
     * Login user and receive token
     *
     * @param AuthRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws AttemptFailedException
     */
    public function login(AuthRequest $request)
    {
        if (!auth()->attempt($request->only('phone', 'password'))) {
            throw new AttemptFailedException();
        }

        $user = auth()->user();
        $rememberMe = $request->input('remember_me', false);

        //Generate token
        $payloadable = [
            'id' => $user->id
        ];

        $token = JWTAuth::fromUser($user, $payloadable);

        return response()->json([
            'result' => 'success',
            'data' => [
                'token' => $token
            ]
        ]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     */
    public function iam(Request $request){
        $token = JWTAuth::getToken();
        $payload = JWTAuth::getPayload($token)->toArray();

        if (!array_key_exists('sub', $payload)) {
            throw new AuthorizationException();
        }

        $user = User::where('id', $payload['sub'])
            ->first();

        if($user == null){
            return response()->json([
                'result' => 'success',
                'data' => null
            ]);
        }

        return response()->json([
            'result' => 'success',
            'data' => $user
        ]);
    }


    /**
     * @param PhoneConfirmRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws AttemptFailedException
     */
    public function register(PhoneConfirmRequest $request)
    {
        if (! $token = auth()->attempt($request->only('phone', 'password'))) {
            throw new AttemptFailedException('Invalid login or password');
        }

        return response()->json([
            'result' => 'success',
            'data' => compact('token')
        ]);
    }

    /**
     * Logout user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['result' => 'success']);
    }

    /**
     * @param $provider
     * @return mixed
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * @param SocialAuthRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws SocialAuthorizationException
     */
    public function socialLogin(SocialAuthRequest $request)
    {
        try {
            $provider = $request->input('provider');
            $code = $request->input('code');

            $social = Socialite::driver($provider)->stateless()->user();
            $user = (new AuthService())->getUserBySocial($provider, $social->getId());

            if ($user == null) {
                $user = $this->createUser($social, $provider);
            }

            $token = JWTAuth::fromUser($user, []);
            return response()->json([
                'result' => 'success',
                'data' => [
                    'token' => $token,
                ]
            ]);
        }catch(ClientException $e){
            throw new AuthorizationException('Social network request error');
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'result' => 'success',
            'data' => [
                'token' => $token,
            ]
        ]);
    }


    /**
     * @param $social
     * @param $provider
     * @return mixed
     */
    private function createUser($social, $provider){
        $user = User::create([
            'name'   => $social->getName(),
            'status' => User::STATUS_FILL_FORM,
        ]);

        $user->userSocial()->save(new UserSocial([
            'provider'         => $provider,
            'provider_user_id' => $social->getId(),
        ]));

        return $user;
    }
}
