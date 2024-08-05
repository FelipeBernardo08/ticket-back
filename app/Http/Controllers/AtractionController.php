<?php

namespace App\Http\Controllers;

use App\Models\Atraction;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;

class AtractionController extends Controller
{
    private $authController;
    public $atraction;

    public function __construct(AuthController $auth, Atraction $atractions)
    {
        $this->authController = $auth;
        $this->atraction = $atractions;
    }

    public function readAtractions(): object
    {
        $result = $this->atraction->readAtractions();
        if (count($result) == 0) {
            return response()->json(['error' => 'Registros nao encontrados!'], 404);
        }
        return $this->resultOk($result);
    }

    public function readAtractionsWithShow(): object
    {
        $result = $this->atraction->readAtractionsWithShow();
        if (count($result) == 0) {
            return response()->json(['error' => 'Registros nao encontrados!'], 404);
        }
        return $this->resultOk($result);
    }

    public function readAtrctionWithEventAndSell(): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2 || $auth[0]['id_permission'] == 3) {
            $result = $this->atraction->readAtrctionWithEventAndSell();
            if (count($result) == 0) {
                return response()->json(['error' => 'Registros nao encontrados!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function createAtraction(Request $request): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2 || $auth[0]['id_permission'] == 3) {
            $result = $this->atraction->createAtraction($request);
            if ($result == null) {
                return response()->json(['error' => 'Registros nao foram cadastrados!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function showAtractionId(int $id): object
    {
        $result = $this->atraction->showAtractionId($id);
        if (count($result) == 0) {
            return response()->json(['error' => 'Registro nao encontrado!'], 404);
        }
        return $this->resultOk($result);
    }


    public function updateAtraction(Request $request, int $id): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2 || $auth[0]['id_permission'] == 3) {
            $result = $this->atraction->updateAtraction($request, $id);
            if ($result == false) {
                return response()->json(['error' => 'Registros nao pode ser atualizado']);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function deleteAtraction(int $id): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2 || $auth[0]['id_permission'] == 3) {
            $result = $this->atraction->deleteAtraction($id);
            if ($result == false) {
                return response()->json(['error' => 'Registro nao pode ser excluido!'], 404);
            }
            return response()->json(['MSG' => 'Registro excluido com sucesso!'], 200);
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
