<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show_authenticated(Request $request): JsonResponse
    {
        return response()->json(new UserResource(Auth::user()), Response::HTTP_OK);
    }
}
