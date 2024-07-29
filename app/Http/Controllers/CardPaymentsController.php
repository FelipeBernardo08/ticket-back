<?php

namespace App\Http\Controllers;

use App\Models\card_payments;
use App\Models\Sell;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Str;

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
                $token = Str::random(30);
                $item = json_decode($response[0]->items);
                $payload = ([
                    "id_user" => $response[0]->id_user,
                    "id_event" => $response[0]->id_event,
                    "token_input" => $token,
                    "total_price" => $item[0]->unit_price,
                    "name_ticket" => $item[0]->title,
                    "date_event" => $response[0]->date_event,
                ]);
                $responseSell = $this->sell->createSell($payload);
                if (count($responseSell) == 0) {
                    $payload[0]->token_input = Str::random(30);
                    $responseSell = $this->sell->createSell($payload);
                } else {
                    return response()->json($responseSell, 200);
                }
            }
            return response()->json(['erro' => 'Dados não puderam ser cadastrados.'], 404);
        } else {
            return response()->json(['msg' => 'Não autorizado!'], 401);
        }
    }

    // public function generate(string $token)
    // {
    //     $qrCode = new QrCode($token);
    //     $writer = new PngWriter();
    //     $result = $writer->write($qrCode);
    //     return $result->getString();
    // }
}
