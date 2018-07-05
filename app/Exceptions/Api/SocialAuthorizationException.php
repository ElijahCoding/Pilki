<?php

namespace App\Exceptions\Api;

use App\Exceptions\ApiException;

class SocialAuthorizationException extends ApiException
{
    protected $status = 401;

    protected $code = 1003;

    protected $message = 'Social network authorization exception';
}