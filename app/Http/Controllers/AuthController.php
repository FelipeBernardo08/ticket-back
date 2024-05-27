<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request): Object
    {
        $credentials = $request->all(['email', 'password']);
        $token = auth('api')->attempt($credentials);
        if ($token) {
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Credenciais incorretas!'], 403);
        }
    }

    public function logout(): void
    {
        auth('api')->logout();
    }

    public function me(): Object
    {
        $user = auth('api')->user();
        return response()->json($user, 200);
    }
}
