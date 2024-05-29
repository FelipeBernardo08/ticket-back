<?php

namespace App\Http\Controllers;

use App\Models\Show;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;

class ShowController extends Controller
{
    public $show;
    private $authController;

    public function __construct(AuthController $auth, Show $shows)
    {
        $this->authController = $auth;
        $this->show = $shows;
    }

    public function readShows(): object
    {
        $result = $this->show->readShows();
        dd($result);
        if (count($result) == 0) {
            return response()->json(['error' => 'Não existem registros'], 404);
        }
        return $this->resultOk($result);
    }

    public function readShowId(int $id): object
    {
        $result = $this->show->readShowId($id);
        if (count($result) == 0) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }
        return $this->resultOk($result);
    }

    public function createShow(Request $request): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->show->createShow($request);
            if (count($result) == 0) {
                return response()->json(['error' => 'Registro não pode ser criado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function updateShow(Request $request, int $id): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->show->updateShow($request, $id);
            if ($result == false) {
                return response()->json(['error' => 'Registro não pode ser atualizado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }


    public function deleteShow(int $id): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->show->deleteShow($id);
            if ($result == false) {
                return response()->json(['error' => 'Registro não pode ser excluído!'], 404);
            }
            return response()->json(['MSG' => 'Registro excluído com sucesso!'], 200);
        } else {
            $this->acessoNegado();
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
