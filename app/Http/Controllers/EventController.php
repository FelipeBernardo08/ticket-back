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

    public function readEvents(): object
    {
        $result = $this->event->readEvents();
        if (count($result) == 0) {
            return response()->json(['error' => 'Não existem registros.'], 404);
        }
        return $this->resultOk($result);
    }

    public function readEventsComplete(): object
    {
        $response = $this->event->readEventsComplete();
        if (count($response) == 0) {
            return response()->json(['error' => 'Registro não encontrado'], 404);
        } else {
            return $this->resultOk($response);
        }
    }

    public function readEventsDate(string $data): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2 || $auth[0]['id_permission'] == 3 ||  $auth[0]['id_permission'] == 4) {
            $result = $this->event->readEventsDate($data, $auth[0]['id']);
            if (count($result) == 0) {
                return response()->json(['error' => 'Não existem registros.'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function readEventsWithAtraction(): object
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
        if ($auth[0]['id_permission'] == 2 || $auth[0]['id_permission'] == 3) {
            $result = $this->event->createEvents($request, $auth[0]);
            if ($result == false) {
                return response()->json(['error' => 'Registros não foram criados!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function showEventId(int $id): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2 || $auth[0]['id_permission'] == 3) {
            $result = $this->event->showEventId($id, $auth[0]['id']);
            if (count($result) == 0) {
                return response()->json(['error' => 'Registro não encontrado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function showEventIdComplete(int $id): object
    {
        $result = $this->event->showEventIdComplete($id);
        if (count($result) == 0) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }
        return $this->resultOk($result);
    }

    public function showEventIdWithAtractions(int $id): object
    {
        $result = $this->event->showEventIdWithAtractions($id);
        if (count($result) == 0) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }
        return $this->resultOk($result);
    }

    public function updateEvent(Request $request, int $id): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2 || $auth[0]['id_permission'] == 3) {
            $result = $this->event->updateEvent($request, $id, $auth[0]['id']);
            if ($result == false) {
                return response()->json(['error' => 'Registro não pode ser atualizado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function deleteEvent(int $id): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2 || $auth[0]['id_permission'] == 3) {
            $result = $this->event->deleteEvent($id, $auth[0]['id']);
            if ($result == false) {
                return response()->json(['error' => 'Registro não pode ser deletado.'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function readEventsWithSells(int $id): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2 || $auth[0]['id_permission'] == 3) {
            $result = $this->event->readEventsWithSells($id, $auth[0]['id']);
            if (count($result) == 0) {
                return response()->json(['error' => 'Registros não encontrados!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function readEventWithSells(): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2 || $auth[0]['id_permission'] == 3) {
            $result = $this->event->readEventWithSells($auth[0]['id']);
            if (count($result) == 0) {
                return response()->json(['error' => 'Registros não encontrados!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function changeActiveEvent(Request $request, int $id): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2 || $auth[0]['id_permission'] == 3) {
            $result = $this->event->changeActiveEvent($id, $auth[0]['id'], $request);
            if ($result) {
                return response()->json(['msg' => 'Evento atualizado com sucesso!'], 200);
            }
            return response()->json(['msg' => 'Evento não pode ser atualizado!'], 500);
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
