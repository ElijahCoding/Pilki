<?php


namespace App\Exceptions\Api;


use App\Exceptions\ApiException;

class AuthResetPasswordInvalidTokenException extends ApiException
{
    protected $status = 400;

    protected $code = 1011;

    protected $message = 'Invalid remember token';
}