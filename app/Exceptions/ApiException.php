<?php


namespace App\Exceptions;



abstract class ApiException extends \Exception
{
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZE = 401;
    const HTTP_NOT_FOUND = 404;
    const HTTP_UNPROCESS_ENTITY = 422;
    const HTTP_INTERNAL_SERVER_ERROR = 500;

    protected $statusCode = self::HTTP_INTERNAL_SERVER_ERROR;

    /**
     * Exception response error bag
     *
     * @return null
     */
    public function errors(){
        return null;
    }

    /**
     * Exception response data bag
     *
     * @return null
     */
    public function data(){
        return null;
    }

    /**
     * Response HTTP status code
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}