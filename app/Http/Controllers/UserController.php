<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeNameRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use App\Services\Results\ResponseResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\returnValue;

class UserController extends Controller
{
    public function show(Request $request, int $id): JsonResponse
    {
        return ResponseResult::success(
            User::where('id', $id)
                ->first()
                ->getValidatedData()
        )->returnValue;
    }

    public function showAuthenticated(Request $request): JsonResponse
    {
        return $this->show($request, Auth::user()->id);
    }

    public function changeName(ChangeNameRequest $request, User $user): JsonResponse
    {
        $user->name = $request->nickname;
        $user->save();

        return $this->show($request, $user->id);
    }

    public function changePassword(ChangePasswordRequest $request, User $user): JsonResponse
    {
        if (!Hash::check($request->old_password, $user->password)) {
            return ResponseResult::error(
                ['password' => ['Incorrect old password']],
                Response::HTTP_UNPROCESSABLE_ENTITY
            )->error;
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return ResponseResult::success()->returnValue;
    }
}
