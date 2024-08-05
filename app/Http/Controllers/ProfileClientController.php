<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Models\ProfileClient;

class ProfileClientController extends Controller
{
    private $authController;
    public $profileClient;

    public function __construct(AuthController $auth, ProfileClient $profileClients)
    {
        $this->authController = $auth;
        $this->profileClient = $profileClients;
    }

    public function updateSelfClient(Request $request): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] != 4) {
            $response = $this->profileClient->updateSelfClient($auth[0]['id'], $request);
            if ($response) {
                return response()->json(['msg' => 'Dados atualizados com sucesso!'], 200);
            }
            return response()->json(['error' => 'Dados não foram atualizados!'], 404);
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
