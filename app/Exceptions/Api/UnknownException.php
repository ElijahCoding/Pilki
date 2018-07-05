<?php


namespace App\Exceptions\Api;


use App\Exceptions\ApiException;

class UnknownException extends ApiException
{
    protected $statusCode = 500;

    protected $code = 1000;
}