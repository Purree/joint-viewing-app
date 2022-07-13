<?php

namespace App\Services\Results;

interface ResultInterface
{
    public static function success(mixed $returnValue = null): FunctionResult;

    public static function error(string|array $error): FunctionResult;
}
