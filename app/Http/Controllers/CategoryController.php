<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;

class CategoryController extends Controller
{
    private $authController;
    public $category;

    public function __construct(AuthController $auth, Category $categories)
    {
        $this->authController = $auth;
        $this->category = $categories;
    }

    public function readCategories(): object
    {
        $result = $this->category->readCategories();
        if (count($result) == 0) {
            return response()->json(['error' => 'Não existem registros!'], 404);
        }
        return $this->resultOk($result);
    }

    public function readCategoriesWithProducts(): object
    {
        $result = $this->category->readCategoriesWithProducts();
        if (count($result) == 0) {
            return response()->json(['error' => 'Não existem registros!'], 404);
        }
        return $this->resultOk($result);
    }

    public function createCategory(Request $request): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->category->createCategory($request);
            if ($result == false) {
                return response()->json(['error' => 'Registros não foram criados!'], 404);
            }
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function showCategoryId(int $id): object
    {
        $result = $this->category->showCategoryId($id);
        if (count($result) == 0) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }
        return $this->resultOk($result);
    }

    public function showCategoryIdWithProducts(int $id): object
    {
        $result = $this->category->showCategoryIdWithProducts($id);
        if (count($result) == 0) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }
        return $this->resultOk($result);
    }

    public function updateCategory(Request $request, int $id): object
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->category->updateCategory($request, $id);
            if ($result == false) {
                return response()->json(['error' => 'Registro não pode ser atualizado!'], 404);
            }
            return $this->resultOk($result);
        } else {
            $this->acessoNegado();
        }
    }

    public function deleteCategory(int $id)
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->category->deleteCategory($id);
            if ($result == false) {
                return response()->json(['error' => 'Resgistro não pode ser deletado!'], 404);
            }
            return response()->json(['MSG' => 'Registro excluído com sucesso!'], 200);
        } else {
            return $this->acessoNegado();
        }
    }

    public function acessoNegado(): object
    {
        return response()->json(['error' => 'Acesso negado!'], 403);
    }

    public function resultOk($result): object
    {
        return response()->json($result, 200);
    }
}
