<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;

use function Ramsey\Uuid\v1;

class UserController extends Controller
{
    public $user;
    private $authController;

    public function __construct(AuthController $auth, User $users)
    {
        $this->authController = $auth;
        $this->user = $users;
    }

    public function createClient(Request $request): object
    {
        $response = $this->user->createClient($request);
        if (count($response) == 0) {
            return response()->json(['error' => 'Registro não pode ser criado!'], 404);
        } else {
            return $this->resultOk($response);
        }
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

    public function readUsers(): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->user->readUsers();
            if (count($result) == 0) {
                return response()->json(['error' => 'Registros não encontrados!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function readUserId(int $id): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->user->readUserId($id);
            if (count($result) == 0) {
                return response()->json(['error' => 'Registro não encontrado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function updateUser(int $id, Request $request): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2) {
            $result = $this->user->updateUser($id, $request);
            if (!$result) {
                return response()->json(['error' => 'Registro não pode ser atualiado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function updateSelf(Request $request): object
    {
        $auth = $this->authController->me();
        $id = $auth->id;
        $result = $this->user->updateUserSelf($id, $request);
        return $this->resultOk($result);
    }

    public function deleteUser(int $id): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->user->deleteUser($id);
            if (!$result) {
                return response()->json(['error' => 'Registro não pode ser deletado!'], 404);
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
