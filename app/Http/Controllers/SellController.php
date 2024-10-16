<?php

namespace App\Http\Controllers;

use App\Models\Sell;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;

class SellController extends Controller
{
    private $authController;
    public $sell;

    public function __construct(AuthController $auth, Sell $sells)
    {
        $this->authController = $auth;
        $this->sell = $sells;
    }

    public function readSells(): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2) {
            $result = $this->sell->readSells();
            if (count($result) == 0) {
                return response()->json(['error' => 'Não existem registros cadastrados'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function readSellsToken(string $token): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] != 1) {
            $result = $this->sell->readSellsToken($token);
            if (count($result) == 0) {
                return response()->json(['error' => 'Acesso negado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            $this->acessoNegado();
        }
    }

    public function validVerificated(int $id): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] != 1) {
            $result = $this->sell->validVerificated($id);
            if ($result == false) {
                return response()->json(['error' => 'Registro não pode ser atualizado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function readSellId(int $id)
    {
        $result = $this->sell->readSellId($id);
        if (count($result) == 0) {
            return response()->json(['error' => 'Registro não encontrado.'], 404);
        }
        return $this->resultOk($result);
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
