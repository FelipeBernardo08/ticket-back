<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Models\ProfileEmployee;
use App\Models\User;

class ProfileEmployeeController extends Controller
{
    private $employee;
    private $authController;
    private $user;

    public function __construct(ProfileEmployee $emplo, AuthController $auth, User $users)
    {
        $this->employee = $emplo;
        $this->authController = $auth;
        $this->user = $users;
    }

    public function createEmployee(Request $request): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2 || $auth[0]['id_permission'] == 3) {
            $responseUser = $this->user->createUserEmployee($request);
            if (count($responseUser) != 0) {
                $response = $this->employee->createEmployee($request, $auth[0]['productor'][0]['id'], $responseUser['id']);
                return $this->resultOk($response);
            }
        } else {
            return $this->acessoNegado();
        }
    }

    public function getUserEmployee(): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2 || $auth[0]['id_permission'] == 3) {
            $response = $this->employee->getUserEmployee($auth[0]['productor'][0]['id']);
            if (count($response) != 0) {
                return $this->resultOk($response);
            }
            return response()->json(['error' => 'Não encontrado'], 404);
        } else {
            return $this->acessoNegado();
        }
    }

    public function getUserEmployeeId(int $id): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2 || $auth[0]['id_permission'] == 3) {
            $response = $this->employee->getUserEmployeeId($id, $auth[0]['productor'][0]['id']);
            if (count($response) != 0) {
                return $this->resultOk($response);
            }
            return response()->json(['error' => 'Não encontrado'], 404);
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
