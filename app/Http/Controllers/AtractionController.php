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

    public function readAtractions(): object //ok
    {
        $result = $this->atraction->readAtractions();
        if (count($result) == 0) {
            return response()->json(['error' => 'Registros nao encontrados!'], 404);
        }
        return $this->resultOk($result);
    }

    public function readAtractionsWithEvent(): object //ok
    {
        $result = $this->atraction->readAtractionsWithEvent();
        if (count($result) == 0) {
            return response()->json(['error' => 'Registros nao encontrados!'], 404);
        }
        return $this->resultOk($result);
    }


    public function createAtraction(Request $request): object //ok
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->atraction->createAtraction($request);
            if ($result == null) {
                return response()->json(['error' => 'Registros nao foram cadastrados!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function showAtractionId(int $id): object //ok
    {
        $result = $this->atraction->showAtractionId($id);
        if (count($result) == 0) {
            return response()->json(['error' => 'Registro nao encontrado!'], 404);
        }
        return $this->resultOk($result);
    }

    public function showAtractionIdWithEvent($id): object //ok
    {
        $result = $this->atraction->showAtractionIdWithEvent($id);
        if (count($result) == 0) {
            return response()->json(['error' => 'Registro nao encontrado!'], 404);
        }
        return $this->resultOk($result);
    }

    public function updateAtraction(Request $request, int $id): object //ok
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->atraction->updateAtraction($request, $id);
            if ($result == false) {
                return response()->json(['error' => 'Registros nao pode ser atualizado']);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function deleteAtraction(int $id): object //ok
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
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
        return response()->json(['error' => 'Acesso negado!'], 403);
    }

    public function resultOk($result): object
    {
        return response()->json($result, 200);
    }
}
