<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeNameRequest;
use App\Models\User;
use App\Services\Results\ResponseResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    public function changeName(ChangeNameRequest $request, User $user = null): JsonResponse
    {
        try {
            if ($user === null) {
                $user = Auth::user();
            }

            $user->name = $request->nickname;
            $user->save();

            return $this->show($request, $user->id);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return ResponseResult::error()->error;
        }
    }
}
