<?php

namespace App\Http\Controllers\Api\Crm;

use App\Exceptions\Api\AttemptFailedException;
use App\Exceptions\Api\AuthorizationException;
use App\Exceptions\Api\AuthResetPasswordInvalidTokenException;
use App\Exceptions\Api\Employer\NotFoundException as EmployerNotFoundException;
use App\Helpers\CacheKeys;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Crm\AuthResetPassword;
use App\Http\Requests\Api\Crm\AuthResetPasswordSend;
use App\Http\Requests\Api\Crm\EmailConfirmRequest;
use App\Models\Employer;
use App\Repositories\EmployerRepository;
use Cache;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Jobs\SendSMS;

class AuthController extends Controller
{
    /**
     * Login user and receive token
     *
     * @param EmailConfirmRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws AttemptFailedException
     * @throws AuthorizationException
     */
    public function login(EmailConfirmRequest $request)
    {
        /** @var Employer $employer */
        $employer = Employer::where('phone', $request->phone)->firstOrFail();

        $this->passwordVerify($request->password, $employer);

        if (!$token = auth()->attempt($request->only('phone', 'password'))) {
            throw new AttemptFailedException();
        }

        Cache::tags(['permissions'])->forget(CacheKeys::PERMISSION_EMPLOYER_KEY . auth()->user()->id);

        return response()->json([
            'result' => 'success',
            'data'   => [
                'token' => $token,
            ],
        ]);
    }

    /**
     * Reset password
     */
    public function resetPassword(AuthResetPassword $request)
    {
        $password = str_random(6);

        /** @var Employer $employer */
        $employer = Employer::wherePhone($request->phone)->firstOrFail();
        $employer->remember_password = bcrypt($password);
        $employer->save();

        SendSMS::dispatch($request->phone, __("Ваш новый пароль: :password", ['password' => $password]));

        return response()->json([
            'result' => 'success',
        ]);
    }


    /**
     * Logout user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->invalidate();

        return response()->json(['result' => 'success']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return response()->json([
            'result' => 'success',
            'data'   => [
                'token' => auth()->refresh(),
            ],
        ]);
    }

    /**
     * @param EmployerRepository $employerRepository
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     */
    public function iam(EmployerRepository $employerRepository, Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            $payload = JWTAuth::getPayload($token)->toArray();

            if (!array_key_exists('sub', $payload)) {
                throw new AuthorizationException();
            }

            if (!$employer = $employerRepository->find($payload['sub'])) {
                throw new EmployerNotFoundException();
            }

            return response()->json([
                'result' => 'success',
                'data'   => $employer,
            ]);
        } catch (EmployerNotFoundException $e) {
            return response()->json([
                'result' => 'success',
                'data'   => null,
            ]);
        }
    }

    protected function passwordVerify($requestPassword, $employer)
    {
        if (!password_verify($requestPassword, $employer->password))
        {
            if ($employer->remember_password && password_verify($requestPassword, $employer->remember_password))
            {
                $employer->password = bcrypt($requestPassword);
                $employer->remember_password = '';
                $employer->save();
            } else {
                throw new AuthorizationException();
            }
        }
    }
}
