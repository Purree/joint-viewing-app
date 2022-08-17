<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RecoveryPasswordRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\TwoFactorLoginRequest;
use App\Models\User;
use App\Services\AuthorizationService;
use App\Services\Results\ResponseResult;
use App\Services\Secrets\Secret;
use App\Services\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\returnValue;

class AuthorizationController extends Controller
{
    protected AuthorizationService $authorizationService;

    public function __construct(AuthorizationService $authorizationService)
    {
        $this->authorizationService = $authorizationService;
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        $login_attempt = $this->authorizationService->login($request->email, $request->password, $request->token);

        if ($login_attempt->status === Status::ERROR) {
            return ResponseResult::error($login_attempt->error)->error;
        }

        if (in_array('two-factor', $login_attempt->returnValue, true) && $login_attempt->returnValue['two-factor']) {
            $request->session()->put(
                TwoFactorLoginRequest::SESSION_TWO_FACTOR_NAME,
                $login_attempt->returnValue['attempt_user']->id
            );

            return ResponseResult::success(['two-factor' => true])->returnValue;
        }

        return ResponseResult::success($login_attempt->returnValue)->returnValue;
    }

    public function registration(RegisterUserRequest $request): JsonResponse
    {
        $registration_attempt = $this->authorizationService->registration(
            $request->name,
            $request->email,
            $request->password
        );

        return ResponseResult::success($registration_attempt->returnValue, Response::HTTP_CREATED)->returnValue;
    }

    public function logout(Request $request): JsonResponse
    {
        $logout_attempt = $this->authorizationService->logout();

        return ResponseResult::success($logout_attempt->returnValue)->returnValue;
    }

    public function recoveryPassword(RecoveryPasswordRequest $request): JsonResponse
    {
        $recovery_password_attempt = $this->authorizationService->recoveryPassword(
            $request->email,
            $request->password,
            $request->secret,
        );

        if ($recovery_password_attempt->status === Status::ERROR) {
            return ResponseResult::error($recovery_password_attempt->error, Response::HTTP_UNPROCESSABLE_ENTITY)->error;
        }

        return ResponseResult::success($recovery_password_attempt->returnValue)->returnValue;
    }
}
