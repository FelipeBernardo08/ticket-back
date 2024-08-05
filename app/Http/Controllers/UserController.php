<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ProfileClient;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Mail;
use App\Mail\EMail;
use App\Mail\ConfirmAccount;
use Illuminate\Support\Str;


use function Ramsey\Uuid\v1;

class UserController extends Controller
{
    public $user;
    public $authController;
    public $profileClient;

    public function __construct(
        AuthController $auth,
        User $users,
        ProfileClient $profileClients
    ) {
        $this->authController = $auth;
        $this->user = $users;
        $this->profileClient = $profileClients;
    }

    public function createClient(Request $request): object
    {
        $response = $this->user->createClient($request);
        if (count($response) == 0) {
            return response()->json(['error' => 'Registro não pode ser criado!'], 404);
        } else {
            if ($response['id_permission'] == 1) {
                $result = $this->profileClient->createClient($request->name, $response['id']);
                if (count($result) != 0) {
                    $this->sendEmailConfirmation($response);
                    return $this->resultOk($response);
                }
            }
        }
    }

    public function createUser(Request $request): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2) {
            $result = $this->user->createUser($request);
            if (count($result) == 0) {
                return response()->json(['error' => 'Registro não pode ser criado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function readUsers(): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2 || $auth['id_permission'] == 3) {
            $result = $this->user->readUsers();
            if (count($result) == 0) {
                return response()->json(['error' => 'Registros não encontrados!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function readUserId(int $id): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2 || $auth['id_permission'] == 3) {
            $result = $this->user->readUserId($id);
            if (count($result) == 0) {
                return response()->json(['error' => 'Registro não encontrado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function updateUser(int $id, Request $request): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2) {
            $result = $this->user->updateUser($id, $request);
            if (!$result) {
                return response()->json(['error' => 'Registro não pode ser atualiado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function deleteUser(int $id): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] == 2) {
            $result = $this->user->deleteUser($id);
            if (!$result) {
                return response()->json(['error' => 'Registro não pode ser deletado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }


    public function updatePassword(Request $request): object
    {
        $auth = $this->authController->me();
        if ($auth[0]['id_permission'] != 0) {
            $result = $this->user->updatePassword($auth, $request);
            if (!$result) {
                return response()->json(['error' => 'Registro não pode ser atualizado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function passwordReset(Request $request): object
    {
        $newPass = Str::random(10);
        $result = $this->user->updatePasswordByEmail($request->email, $newPass);
        if ($result) {
            Mail::to($request->email)->send(new EMail($newPass, 'Senha Provisória'));
            return response()->json(['msg' => "E-mail enviado com sucesso!"], 200);
        } else {
            return response()->json(['error' => 'Registro não pode ser atualizado!'], 404);
        }
    }

    public function confirmAccount(string $email): object
    {
        $result = $this->user->confirmAccount($email);
        if ($result) {
            return redirect()->route('thank-you');
        }
    }

    public function sendEmailConfirmation($response): void
    {
        $url = 'http://127.0.0.1:8000/api/confirm-account/' . $response['email']; //dev
        // $url = 'https://back.bancaevento.com.br:8080/api/confirm-account/' . $response['email']; //prod
        Mail::to($response['email'])->send(new ConfirmAccount($url, 'Confirmar Conta'));
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
