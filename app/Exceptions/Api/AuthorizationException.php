<?php

namespace App\Exceptions\Api;

use App\Exceptions\ApiException;

class AuthorizationException extends ApiException
{
    protected $status = 401;

    protected $code = 1010;

    protected $message = 'Authorization exception';
}