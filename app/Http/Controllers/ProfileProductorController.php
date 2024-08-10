<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Models\ProfileProductor;

class ProfileProductorController extends Controller
{
    private $authController;
    private $profileProductor;

    public function __construct(AuthController $auth, ProfileProductor $profile)
    {
        $this->authController = $auth;
        $this->profileProductor = $profile;
    }

    public function updateProductor(Request $request): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 3) {
            $response = $this->profileProductor->updateProductor($request, $auth[0]['id']);
            if ($response) {
                return response()->json(['msg' => 'Registro atualizado com sucesso!'], 200);
            }
            return response()->json(['error' => 'Dados não foram atualizados'], 404);
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
