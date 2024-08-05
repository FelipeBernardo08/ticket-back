<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;


class TicketController extends Controller
{

    public $ticket;
    private $authController;

    public function __construct(AuthController $auth, Ticket $tickets)
    {
        $this->authController = $auth;
        $this->ticket = $tickets;
    }

    public function readTikects(): object
    {
        $result = $this->ticket->readTikects();
        if (count($result) == 0) {
            return response()->json(['error' => 'Não existem registros cadastrados.'], 404);
        }
        return $this->resultOk($result);
    }

    public function readTikectsWithEvent(): object
    {
        $result = $this->ticket->readTikectsWithEvent();
        if (count($result) == 0) {
            return response()->json(['error' => 'Não existem registros cadastrados.'], 404);
        }
        return $this->resultOk($result);
    }

    public function createTicket(Request $request): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2) {
            $result = $this->ticket->createTicket($request);
            if ($result == false) {
                return response()->json(['error' => 'Registro não pode ser criado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function readTicketId(int $id): object
    {
        $result = $this->ticket->readTicketId($id);
        if (count($result) == 0) {
            return response()->json(['erro' => 'Registro não encontrado.'], 404);
        }
        return $this->resultOk($result);
    }

    public function updateTicket(Request $request, int $id): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2) {
            $result = $this->ticket->updateTicket($request, $id);
            if ($result == false) {
                return response()->json(['error' => 'Registro não pode ser atualizado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function deleteTicket(int $id): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2) {
            $result = $this->ticket->deleteTicket($id);
            if ($result == false) {
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
