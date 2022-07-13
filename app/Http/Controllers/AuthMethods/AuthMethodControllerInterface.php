<?php

namespace App\Http\Controllers\AuthMethods;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface AuthMethodControllerInterface
{
    public function getAll(Request $request, User $user): JsonResponse;

    public function revokeAll(Request $request, User $user): JsonResponse;

    public function revoke(Request $request, User $user, int|string $authId): JsonResponse;
}
