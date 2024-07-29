<?php

namespace App\Http\Controllers;

use App\Models\card_payments;
use App\Models\Sell;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;


class CardPaymentsController extends Controller
{
    private $cardPay;
    private $authController;
    private $sell;

    public function __construct(AuthController $auth, card_payments $cardPayments, Sell $sells)
    {
        $this->cardPay = $cardPayments;
        $this->authController = $auth;
        $this->sell = $sells;
    }

    public function createCardPayment(Request $request): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission != 0) {
            $response = $this->cardPay->createCardPayment($request, $auth);
            if ($response) {
                return response()->json($response, 200);
            }
            return response()->json(['erro' => 'Dados não puderam ser cadastrados.'], 404);
        } else {
            return response()->json(['msg' => 'Não autorizado!'], 401);
        }
    }

    public function getCardsPayment(): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission != 0) {
            $id = $auth->id;
            $response = $this->cardPay->getCardsPayment($id);
            if ($response) {
                return response()->json($response, 200);
            }
            return response()->json(['erro' => 'Dados não encontrados.'], 404);
        } else {
            return response()->json(['msg' => 'Não autorizado!'], 401);
        }
    }

    public function deleteCardPayment(int $id): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission != 0) {
            $id_user = $auth->id;
            $response = $this->cardPay->deleteCardPayment($id_user, $id);
            if ($response) {
                return response()->json($response, 200);
            }
            return response()->json(['erro' => 'Dados não deletados.'], 404);
        } else {
            return response()->json(['msg' => 'Não autorizado!'], 401);
        }
    }

    public function updateLinkPayment(Request $request, int $id): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission != 0) {
            $response = $this->cardPay->updateLinkPayment($request, $auth, $id);
            if ($response) {
                return response()->json($response, 200);
            }
            return response()->json(['erro' => 'Dados não puderam ser cadastrados.'], 404);
        } else {
            return response()->json(['msg' => 'Não autorizado!'], 401);
        }
    }


    public function updateCardPayment(Request $request, int $id): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission != 0) {
            $response = $this->cardPay->updateCardPayment($request, $auth, $id);
            if (count($response) != 0) {
                $token = '123456';
                $item = json_decode($response[0]->items);
                $payload = ([
                    "id_user" => $response[0]->id_user,
                    "id_event" => $response[0]->id_event,
                    "token_input" => $token,
                    "total_price" => $item[0]->unit_price,
                    "name_ticket" => $item[0]->title,
                    "date_event" => $response[0]->date_event,
                ]);
                return response()->json($this->sell->createSell($payload), 200);
            }
            return response()->json(['erro' => 'Dados não puderam ser cadastrados.'], 404);
        } else {
            return response()->json(['msg' => 'Não autorizado!'], 401);
        }
    }
}
