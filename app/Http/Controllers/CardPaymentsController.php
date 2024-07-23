<?php

namespace App\Http\Controllers;

use App\Models\card_payments;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;


class CardPaymentsController extends Controller
{
    private $cardPay;
    private $authController;

    public function __construct(AuthController $auth, card_payments $cardPayments)
    {
        $this->cardPay = $cardPayments;
        $this->authController = $auth;
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


    public function updateCardPayment(Request $request, int $id): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission != 0) {
            $response = $this->cardPay->updateCardPayment($request, $auth, $id);
            if ($response) {
                return response()->json($response, 200);
            }
            return response()->json(['erro' => 'Dados não puderam ser cadastrados.'], 404);
        } else {
            return response()->json(['msg' => 'Não autorizado!'], 401);
        }
    }
}
