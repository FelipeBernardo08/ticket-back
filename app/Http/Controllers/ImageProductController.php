<?php

namespace App\Http\Controllers;

use App\Models\ImageProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;


class ImageProductController extends Controller
{
    private $authController;
    public $imgProduct;

    public function __construct(AuthController $auth, ImageProduct $imageProduct)
    {
        $this->authController = $auth;
        $this->imgProduct = $imageProduct;
    }

    public function createImgProduct(Request $request): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->imgProduct->createImgProduct($request);
            if (count($result) == 0) {
                return response()->json(['error' => 'Registro não pode ser criado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function readImgProduct(int $id): object
    {
        $result = $this->imgProduct->readImgProduct($id);
        if (count($result) == 0) {
            return response()->json(['error' => 'Registro não encontrado'], 404);
        } else {
            return $this->resultOk($result);
        }
    }

    public function deleteImgProduct(int $id): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->imgProduct->deleteImgProduct($id);
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
