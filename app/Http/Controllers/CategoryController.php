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

    public function readCategories(): object //ok
    {
        $result = $this->category->readCategories();
        if (count($result) == 0) {
            return response()->json(['error' => 'Nao existem registros!'], 404);
        }
        return $this->resultOk($result);
    }

    public function readCategoriesWithProducts(): object //ok
    {
        $result = $this->category->readCategoriesWithProducts();
        if (count($result) == 0) {
            return response()->json(['error' => 'Nao existem registros!'], 404);
        }
        return $this->resultOk($result);
    }

    public function createCategory(Request $request): object //ok
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->category->createCategory($request);
            return $this->resultOk($result);
        } else {
            return $this->acessoNegado();
        }
    }

    public function showCategoryId(int $id): object //ok
    {
        $result = $this->category->showCategoryId($id);
        if (count($result) == 0) {
            return response()->json(['error' => 'Registro nao encontrado!'], 404);
        }
        return $this->resultOk($result);
    }

    public function showCategoryIdWithProducts(int $id): object //ok
    {
        $result = $this->category->showCategoryIdWithProducts($id);
        if (count($result) == 0) {
            return response()->json(['error' => 'Registro nao encontrado!'], 404);
        }
        return $this->resultOk($result);
    }

    public function updateCategory(Request $request, int $id): object //ok
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->category->updateCategory($request, $id);
            if ($result == false) {
                return response()->json(['error' => 'Resgistro nao pode ser atualizado!'], 404);
            }
            return response()->json(['MSG' => 'Registro atualizado com sucesso!'], 200);
        } else {
            $this->acessoNegado();
        }
    }

    public function deleteCategory(int $id) //ok
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->category->deleteCategory($id);
            if ($result == false) {
                return response()->json(['error' => 'Resgistro nao pode ser deletado!'], 404);
            }
            return response()->json(['MSG' => 'Registro excluido com sucesso!'], 200);
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
