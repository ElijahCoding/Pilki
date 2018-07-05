<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        NotFoundHttpException::class,
        AuthenticationException::class,
        ApiException::class,
        TokenExpiredException::class,
    ];

    /**
     * Map standart exception codes
     * Example: class => [code, httpCode, message]
     *
     * @var array
     */
    protected $exceptionCodes = [
        AuthenticationException::class                             => [401, 401, 'unauthenticated'],
        TokenExpiredException::class                               => [1005, 400, 'expired token'],
        Api\Employer\NotFoundException::class                      => [1200, 404, 'employer not found'],
        Api\Employer\Schedule\AlreadyApprovedException::class      => [1210, 500, 'already approved'],
        Api\Employer\Schedule\EquipmentWindowEmptyException::class => [1211, 500, 'equipment window empty'],
        Api\Employer\Schedule\TooSmallException::class             => [1212, 500, 'schedule too small'],
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     *
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        if (!method_exists($exception, 'render') && $request->ajax()) {
            if (isset($this->exceptionCodes[get_class($exception)])) {
                $code = $this->exceptionCodes[get_class($exception)][0];
                $statusCode = $this->exceptionCodes[get_class($exception)][1];
                $message = $this->exceptionCodes[get_class($exception)][2] ?? $exception->getMessage();
            } else {
                $statusCode = method_exists($exception, 'getStatusCode')
                    ? $exception->getStatusCode() :
                    $exception->status ?? ApiException::HTTP_INTERNAL_SERVER_ERROR;

                $code = $exception->getCode() ?: $statusCode;
                $message = $exception->getMessage();
            }

            $payload = [
                'result'  => 'error',
                'code'    => $code,
                'message' => $message,
            ];

            if (method_exists($exception, 'errors')) {
                $errors = $exception->errors();
                if (!is_null($errors)) {
                    $payload['errors'] = $errors;
                }
            }

            if (method_exists($exception, 'data')) {
                $data = $exception->data();
                if (!is_null($data)) {
                    $payload['data'] = $data;
                }
            }

            if (config('app.debug')) {
                $payload['exception'] = get_class($exception);
                $payload['trace'] = $exception->getTrace();
            }

            return response()->json($payload, $statusCode);
        }
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'result'  => 'error',
                'code'    => 401,
                'message' => 'unauthenticated',
            ], 401);
        }
        $guard = array_get($exception->guards(), 0);
        switch ($guard) {
            case 'employers':
                $login = 'crm.auth.login';
                break;
            default:
                $login = 'users.auth.login';
                break;
        }
        return redirect()->guest(route($login));
    }
}
