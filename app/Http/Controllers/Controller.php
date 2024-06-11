<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $authController;
    public $user;

    public function __construct(AuthController $auth, User $users)
    {
        $this->authController = $auth;
        $this->user = $users;
    }

    public function createUser(Request $request): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2) {
            $result = $this->user->createUser($request);
            if (count($result) == 0) {
                return response()->json(['error' => 'Registro não pode ser criado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function acessoNegado(): object
    {
        return response()->json(['error' => 'Acesso negado!'], 401);
    }

    public function resultOk($result): object
    {
        return response()->json($result, 200);
    }
}
