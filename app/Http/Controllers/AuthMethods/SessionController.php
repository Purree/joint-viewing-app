<?php

namespace App\Http\Controllers\AuthMethods;

use App\Http\Controllers\Controller;
use App\Http\Resources\SessionResource;
use App\Models\User;
use App\Services\Results\ResponseResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SessionController extends Controller implements AuthMethodControllerInterface
{
    public function getAll(Request $request, User $user): JsonResponse
    {
        return ResponseResult::success(
            SessionResource::collection($user->sessions()->get())
        )->returnValue;
    }

    public function revokeAll(Request $request, User $user): JsonResponse
    {
        $user->sessions()->delete();

        return ResponseResult::success()->returnValue;
    }

    public function revoke(Request $request, User $user, int|string $authId): JsonResponse
    {
        $session = $user->sessions()->where('id', $authId)->first();

        if ($session === null) {
            return ResponseResult::error(['token' => ['Session not found']], Response::HTTP_NOT_FOUND)->error;
        }

        $session->delete();

        return ResponseResult::success(
            ['logout' => $session->id === $request->session()->getId()]
        )->returnValue;
    }
}