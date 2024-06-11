<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(Request $request): Object
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Credenciais incorretas!'], 403);
        }

        return response()->json(['token' => $token], 200);
    }

    public function logout(): object
    {
        try {
            Auth::guard('api')->logout();
            return response()->json(['message' => 'Logout realizado com sucesso!'], 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Falha ao realizar logout, tente novamente.'], 500);
        }
    }

    public function me()
    {
        $user = auth('api')->user();
        return $user;
    }
}
