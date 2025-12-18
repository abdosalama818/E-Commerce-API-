<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class AuthenticateController extends Controller
{
    public function login(AuthRequest $request)
    {

        
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken()->plainTextToken;
        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => __('info.login'),
            'token' => $token,
      
        ],201);
        
    }
}
