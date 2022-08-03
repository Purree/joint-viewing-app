<?php

namespace App\Services\Results;

use App\Services\Status;

class FunctionResult implements ResultInterface
{
    public Status $status;

    public mixed $returnValue;

    public mixed $error;

    /**
        The constructor is private so that methods are only called statically
     */
    protected function __construct()
    {
    }

    public static function success(mixed $returnValue = null): FunctionResult
    {
        $result = new self();
        $result->status = Status::OK;
        $result->returnValue = $returnValue;

        return $result;
    }

    public static function error(string|array $error): FunctionResult
    {
        $result = new self();
        $result->status = Status::ERROR;
        $result->error = $error;

        return $result;
    }
}
