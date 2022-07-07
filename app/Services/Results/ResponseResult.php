<?php

namespace App\Services\Results;

use Illuminate\Http\Response;

class ResponseResult extends FunctionResult
{
    public static function success(mixed $returnValue = []): FunctionResult
    {
        $result = new self();
        $result->success = true;
        $result->returnValue = response()->json($returnValue, Response::HTTP_OK);

        return $result;
    }

    public static function error(
        string|array $error = 'Some problems. Try again later.',
        int $errorCode = Response::HTTP_INTERNAL_SERVER_ERROR
    ): FunctionResult {
        $result = new self();
        $result->success = false;

        $result->error = response()->json(
            [
                'errors' => is_array($error) ? $error : ['server' => [$error]],
            ],
            $errorCode
        );

        return $result;
    }
}
