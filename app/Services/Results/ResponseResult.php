<?php

namespace App\Services\Results;

use App\Services\Status;
use Illuminate\Http\Response;

class ResponseResult extends FunctionResult
{
    public static function success(mixed $returnValue = [], int $responseCode = Response::HTTP_OK): FunctionResult
    {
        $result = new self();
        $result->status = Status::OK;
        $result->returnValue = response()->json($returnValue, $responseCode);

        return $result;
    }

    public static function error(
        string|array $error = 'Some problems. Try again later.',
        int $errorCode = Response::HTTP_INTERNAL_SERVER_ERROR
    ): FunctionResult {
        $result = new self();
        $result->status = Status::ERROR;

        $result->error = response()->json(
            [
                'errors' => is_array($error) ? $error : ['server' => [$error]],
            ],
            $errorCode
        );

        return $result;
    }
}
