<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthorizationController extends Controller
{
    public function login(LoginUserRequest $request): JsonResponse
    {
        if (Auth::attempt($request->validated())) {
            $token = Auth::user()->createToken('api');

            return response()->json([
                'token' => $token->plainTextToken,
            ]);
        }

        return response()->json(['errors' => ['auth' => ['Incorrect user or password.']]], Response::HTTP_UNAUTHORIZED);
    }

    public function registration(RegisterUserRequest $request): JsonResponse
    {
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return response()->json(
                ['errors' => ['server' => ['Some problems. Try again later.']]],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $token = auth()->user()->currentAccessToken();
            if($token && method_exists(auth()->user()->currentAccessToken(), 'delete'))
            {
                auth()->user()->currentAccessToken()->delete();
            }

            auth()->guard('web')->logout();

            return response()->json([], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return response()->json(
                ['errors' => ['server' => ['Some problems. Try again later.']]],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
