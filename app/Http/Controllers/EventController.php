<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;


class EventController extends Controller
{
    private $authController;
    public $event;

    public function __construct(AuthController $auth, Event $events)
    {
        $this->authController = $auth;
        $this->event = $events;
    }

    public function readEvents(): object //ok
    {
        $result = $this->event->readEvents();
        if (count($result) == 0) {
            return response()->json(['error' => 'Não existem registros.'], 404);
        }
        return $this->resultOk($result);
    }

    public function readEventsWithAtraction(): object //ok
    {
        $result = $this->event->readEventsWithAtraction();
        if (count($result) == 0) {
            return response()->json(['error' => 'Não existem registros.'], 404);
        }
        return $this->resultOk($result);
    }

    public function createEvents(Request $request): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->event->createEvents($request);
            if ($result == false) {
                return response()->json(['error' => 'Registros não foram criados!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function showEventId(int $id): object //ok
    {
        $result = $this->event->showEventId($id);
        if (count($result) == 0) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }
        return $this->resultOk($result);
    }

    public function showEventIdWithAtractions(int $id): object //ok
    {
        $result = $this->event->showEventIdWithAtractions($id);
        if (count($result) == 0) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }
        return $this->resultOk($result);
    }

    public function updateEvent(Request $request, int $id): object //ok
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->event->updateEvent($request, $id);
            if ($result == false) {
                return response()->json(['error' => 'Registro não pode ser atualizado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function deleteEvent(int $id): object //ok
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->event->deleteEvent($id);
            if ($result == false) {
                return response()->json(['error' => 'Registro não pode ser deletado.'], 404);
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
