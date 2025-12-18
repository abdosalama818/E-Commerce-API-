<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Request;

class AuthenticateController extends Controller
{
    public function login(AuthRequest $request)
    {


        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                  'success' => true,
                  'status' => 'success',
                'message' => __('info.credintials'),
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken($request->header('User-Agent'))->plainTextToken;
        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => __('info.login'),
            'token' => $token,

        ], 201);
    }

    public function register(AuthRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken($request->header('User-Agent'))->plainTextToken;
        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => __('info.register'),
            'token' => $token,
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => __('info.logout'),
        ], 200);
    }
}
