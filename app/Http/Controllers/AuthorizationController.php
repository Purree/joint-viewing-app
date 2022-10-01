<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RecoveryPasswordRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\TwoFactorLoginRequest;
use App\Services\AuthorizationService;
use App\Services\Results\ResponseResult;
use App\Services\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorizationController extends Controller
{
    protected AuthorizationService $authorizationService;

    public function __construct(AuthorizationService $authorizationService)
    {
        $this->authorizationService = $authorizationService;
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        $loginAttempt = $this->authorizationService->login(
            $request->email,
            $request->password,
            $request->has('remember') && $request->remember,
            $request->token
        );

        if ($loginAttempt->status === Status::ERROR) {
            return ResponseResult::error($loginAttempt->error)->error;
        }

        if (in_array('two-factor', $loginAttempt->returnValue, true) && $loginAttempt->returnValue['two-factor']) {
            $request->session()->put(
                TwoFactorLoginRequest::SESSION_TWO_FACTOR_NAME,
                $loginAttempt->returnValue['attempt_user']->id
            );

            return ResponseResult::success(['two-factor' => true])->returnValue;
        }

        return ResponseResult::success($loginAttempt->returnValue)->returnValue;
    }

    public function registration(RegisterUserRequest $request): JsonResponse
    {
        $registrationAttempt = $this->authorizationService->registration(
            $request->name,
            $request->email,
            $request->password
        );

        return ResponseResult::success($registrationAttempt->returnValue, Response::HTTP_CREATED)->returnValue;
    }

    public function logout(Request $request): JsonResponse
    {
        $logoutAttempt = $this->authorizationService->logout();

        return ResponseResult::success($logoutAttempt->returnValue)->returnValue;
    }

    public function recoveryPassword(RecoveryPasswordRequest $request): JsonResponse
    {
        $recoveryPasswordAttempt = $this->authorizationService->recoveryPassword(
            $request->email,
            $request->password,
            $request->secret,
        );

        if ($recoveryPasswordAttempt->status === Status::ERROR) {
            return ResponseResult::error($recoveryPasswordAttempt->error, Response::HTTP_UNPROCESSABLE_ENTITY)->error;
        }

        return ResponseResult::success($recoveryPasswordAttempt->returnValue)->returnValue;
    }
}
