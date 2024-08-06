<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;

class AuthController extends Controller
{
    public $user;

    public function __construct(User $users)
    {
        $this->user = $users;
    }

    public function login(Request $request): Object
    {
        $response = $this->user->login($request->email);
        if ($response == 'approved') {
            $credentials = $request->only('email', 'password');
            if (!$token = Auth::guard('api')->attempt($credentials)) {
                return response()->json(['error' => 'Credenciais incorretas!'], 403);
            }
            return response()->json(['token' => $token], 200);
        } else if ($response == 'pending') {
            return response()->json(['msg' => 'Ative sua conta no e-mail cadastrado!'], 401);
        } else if ($response == 'inexistente') {
            return response()->json(['msg' => 'Conta não existe!'], 403);
        }
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

    public function me(): array
    {
        $user = auth('api')->user();
        if ($user->id_permission == 1) {
            return $this->user->returnWithClient($user);
        } else if ($user->id_permission == 2) {
            return $this->user->returnWithAdm($user);
        } else if ($user->id_permission == 3) {
            return $this->user->returnWithProdutctor($user);
        } else if ($user->id_permission == 4) {
            return $this->user->returnWithEmployee($user);
        }
    }
}
