<?php

namespace App\Http\Controllers;

use App\Models\PassList;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;


class PassListController extends Controller
{
    private $authController;
    public $passList;

    public function __construct(AuthController $auth, PassList $list)
    {
        $this->authController = $auth;
        $this->passList = $list;
    }

    public function readList(): object
    {
        $result = $this->passList->readList();
        if (count($result) == 0) {
            return response()->json(['error' => 'Registros não encontrados!'], 404);
        }
        return $this->resultOk($result);
    }

    public function createList(Request $request): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->passList->createList($request);
            if (count($result) == 0) {
                return response()->json(['error' => 'Registro não pode ser cadastrado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function readListIdEvent(int $id): object
    {
        $result = $this->passList->readListIdEvent($id);
        if (count($result) == 0) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }
        return $this->resultOk($result);
    }

    public function deleteList(int $id): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->passList->deleteList($id);
            if (!$result) {
                return response()->json(['error' =>  'Registro não pode ser deletado'], 404);
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
