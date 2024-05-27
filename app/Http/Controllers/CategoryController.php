<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $authController;
    public $category;

    public function __construct(AuthController $auth, Category $categories)
    {
        $this->authController = $auth;
        $this->category = $categories;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->category->all();
        if (count($result) == 0) {
            return response()->json(['error' => 'Não existem produtos cadastrados'], 404);
        } else {
            return response()->json($result, 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth = $this->authController->me();
        if (!($auth->id_permission != 2 || $auth->id_permission != 3)) {
            $result = $this->category->create($request->all());
            if ($result == null) {
                return response()->json(['error' => 'Produtos não foram criados!'], 404);
            } else {
                return response()->json($result, 200);
            }
        } else {
            return response()->json(['error' => 'Acesso negado!'], 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->category->find($id);
        if ($result == null) {
            return response()->json(['error' => 'Não existem produtos cadastrados'], 404);
        } else {
            return response()->json($result, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $auth = $this->authController->me();
        if (!($auth->id_permission != 2 || $auth->id_permission != 3)) {
            $result = $this->category->find($id);
            if ($result == null) {
                return response()->json(['error' => 'Não existem produtos cadastrados'], 404);
            } else {
                $result->update($request->all());
                return response()->json($result, 200);
            }
        } else {
            return response()->json(['error' => 'Acesso negado!'], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $auth = $this->authController->me();
        if (!($auth->id_permission != 2 || $auth->id_permission != 3)) {
            $result = $this->category->find($id);
            if ($result == null) {
                return response()->json(['error' => 'Não existem produtos cadastrados'], 404);
            } else {
                $result->delete();
                return response()->json($result, 200);
            }
        } else {
            return response()->json(['error' => 'Acesso negado!'], 403);
        }
    }
}
