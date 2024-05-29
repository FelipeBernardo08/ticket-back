<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;

class TableController extends Controller
{
    public $table;
    private $authController;

    public function __construct(AuthController $auth, Table $tables)
    {
        $this->authController = $auth;
        $this->table = $tables;
    }

    public function readTables(): object
    {
        $result = $this->table->readTables();
        if (count($result) == 0) {
            return response()->json(['error' => 'Não existem registros!'], 404);
        }
        return $this->resultOk($result);
    }

    public function createTable(Request $request, int $id): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->table->createTable($request, $id);
            if ($result == false) {
                return response()->json(['error' => 'Registros não foram criados!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function readTableId(int $id): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission != 1) {
            $result = $this->table->readTableId($id);
            if (count($result) == 0) {
                return response()->json(['error' => 'Rgistro não encontrado.'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function updateTable(Request $request, int $id): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->table->updateTable($request, $id);
            if ($result == false) {
                return response()->json(['error' => 'Registro não pode ser atualizado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function deleteTable(int $id): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->table->deleteTable($id);
            if ($result == false) {
                return response()->json(['error' => 'Registro não pode ser deletado'], 404);
            }
            return response()->json(['MSG' => 'Registro deletado com sucesso!'], 200);
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
