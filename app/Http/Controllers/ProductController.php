<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;

class ProductController extends Controller
{
    private $authController;
    public $product;

    public function __construct(AuthController $auth, Product $products)
    {
        $this->authController = $auth;
        $this->product = $products;
    }

    public function readProducts(): object //ok
    {
        $result = $this->product->readProducts();
        if (count($result) == 0) {
            return response()->json(['error' => 'Não existem registros!'], 404);
        }
        return $this->resultOk($result);
    }

    public function readProductsWithCategories(): object //ok
    {
        $result = $this->product->readProductsWithCategories();
        if (count($result) == 0) {
            return response()->json(['error' => 'Não existem registros!'], 404);
        }
        return $this->resultOk($result);
    }

    public function createProduct(Request $request): object //ok
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->product->createProduct($request);
            if ($result == false) {
                return response()->json(['error' => 'Registro não pode ser criado.'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function showProductId(int $id): object //ok
    {
        $result = $this->product->showProductId($id);
        if (count($result) == 0) {
            return response()->json(['error' => 'Registro não encontrado'], 404);
        }
        return $this->resultOk($result);
    }

    public function showProductIdWithCategory(int $id): object //ok
    {
        $result = $this->product->showProductIdWithCategory($id);
        if (count($result) == 0) {
            return response()->json(['error' => 'Registro não encontrado'], 404);
        }
        return $this->resultOk($result);
    }

    public function updateProduct(Request $request, int $id): object  //ok
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->product->updateProduct($request, $id);
            if ($result == false) {
                return response()->json(['error' => 'Registro não pode ser atualizado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function deleteProduct(int $id): object //ok
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->product->deleteProduct($id);
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
