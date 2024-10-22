<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        User::create($request->validated());

        return response()->json(['message' => "User registered successfully"], 201);
    }

    public function login(Request $request): JsonResponse
    {
        if(!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json(['message' => 'Credentials incorrects'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('token-access', expiresAt: now()->addWeek(1))->plainTextToken;

        return response()->json(['message' => 'login successfully', 'user' => $user, 'access_token' => $token]);
    }

    public function logout(Request $request): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'logout successfully'], 204);
    }
}
