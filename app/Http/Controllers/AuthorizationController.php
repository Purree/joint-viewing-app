<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidArgumentException;
use App\Helpers\Results\ResponseResult;
use App\Helpers\TwoFactorSessionKeyNames;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RecoveryPasswordRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\AuthorizationService;
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
        try {
            $loginAttempt = $this->authorizationService->login(
                $request->email,
                $request->password,
                $request->has('remember') && $request->remember,
                $request->token
            );
        } catch (InvalidArgumentException $exception) {
            return ResponseResult::error(['auth' => [$exception->getMessage()]], Response::HTTP_UNAUTHORIZED);
        }

        if (array_key_exists('two-factor', $loginAttempt) && $loginAttempt['two-factor']) {
            $request->session()->put(
                TwoFactorSessionKeyNames::LOGIN_ATTEMPT->value,
                $loginAttempt['attempt_user']->id
            );

            return ResponseResult::success(['two-factor' => true]);
        }

        return ResponseResult::success($loginAttempt);
    }

    public function registration(RegisterUserRequest $request): JsonResponse
    {
        $registrationAttempt = $this->authorizationService->registration(
            $request->name,
            $request->email,
            $request->password
        );

        return ResponseResult::success($registrationAttempt, Response::HTTP_CREATED);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authorizationService->logout();

        return ResponseResult::success();
    }

    public function recoveryPassword(RecoveryPasswordRequest $request): JsonResponse
    {
        try {
            $recoveryPasswordAttempt = $this->authorizationService->recoveryPassword(
                $request->email,
                $request->password,
                $request->secret,
            );
        } catch (InvalidArgumentException $e) {
            return ResponseResult::error(['secret' => [$e->getMessage()]], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return ResponseResult::success($recoveryPasswordAttempt);
    }
}
