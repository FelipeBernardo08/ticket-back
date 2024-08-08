<?php

namespace App\Http\Controllers;

use App\Models\ImageEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;


class ImageEventController extends Controller
{
    private $authController;
    public $imgEvent;

    public function __construct(AuthController $auth, ImageEvent $imageEvent)
    {
        $this->authController = $auth;
        $this->imgEvent = $imageEvent;
    }

    public function createImgEvent(Request $request): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2 || $auth[0]['id_permission'] == 3) {
            $result = $this->imgEvent->createImgEvent($request);
            if (count($result) == 0) {
                return response()->json(['error' => 'Registro não pode ser criado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function readAllImagesEvents(): object
    {
        $result = $this->readAllImagesEvents();
        if (count($result) == 0) {
            return response()->json(['error' => 'Não existem imagens registradas!'], 404);
        }
        return $this->resultOk($result);
    }

    public function readImagesEvents(int $id): object
    {
        $result = $this->imgEvent->readImagesEvents($id);
        if (count($result) == 0) {
            return response()->json(['error' => 'Não existem imagens registradas!'], 404);
        }
        return $this->resultOk($result);
    }

    public function deleteImgEvent(int $id): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2 || $auth[0]['id_permission'] == 3) {
            $result = $this->imgEvent->deleteImgEvent($id);
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
