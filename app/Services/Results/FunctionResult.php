<?php

namespace App\Services\Results;

class FunctionResult
{
    public bool $success;

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
        $result->success = true;
        $result->returnValue = $returnValue;

        return $result;
    }

    public static function error(string|array $error): FunctionResult
    {
        $result = new self();
        $result->success = false;
        $result->error = $error;

        return $result;
    }
}
