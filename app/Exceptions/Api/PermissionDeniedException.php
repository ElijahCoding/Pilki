<?php


namespace App\Exceptions\Api;


use App\Exceptions\ApiException;

class PermissionDeniedException extends ApiException
{
    protected $status = 401;

    protected $code = 1011;

    protected $message = 'Permission denied';
}