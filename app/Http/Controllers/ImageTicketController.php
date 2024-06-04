<?php

namespace App\Http\Controllers;

use App\Models\ImageTicket;
use Illuminate\Http\Request;

class ImageTicketController extends Controller
{
    private $authController;
    public $imgTicket;

    public function __construct(AuthController $auth, ImageTicket $imageTicket)
    {
        $this->authController = $auth;
        $this->imgTicket = $imageTicket;
    }

    public function createImgTicket(Request $request): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->imgTicket->createImgTicket($request);
            if (count($result) == 0) {
                return response()->json(['error' => 'Registro não pode ser criado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function deleteImgTicket(int $id): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->imgTicket->deleteImgTicket($id);
            if ($result == false) {
                return response()->json(['error' => 'Regisrto não pode ser deletado!'], 404);
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
