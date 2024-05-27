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

    public function logout()
    {
    }

    public function me(): array
    {
        $user = auth('api')->user();
        $userFinal = new User();
        $result = $userFinal->userWithPermission($user->id);
        return $result;
    }
}
