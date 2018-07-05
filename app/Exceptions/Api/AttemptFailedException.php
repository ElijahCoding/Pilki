<?php

namespace App\Exceptions\Api;

use App\Exceptions\ApiException;

class AttemptFailedException extends ApiException
{
    protected $status = 401;

    protected $code = 1002;

    protected $message = 'Invalid login or password';
}
