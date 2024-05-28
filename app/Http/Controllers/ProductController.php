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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->product->all();
        if (count($result) == 0) {
            return response()->json(['error' => 'Não existem registros cadastrados.'], 404);
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
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->product->create($request->all());
            if ($result == null) {
                return response()->json(['error' => 'Registro não pode ser criado.'], 404);
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
        $result = $this->product->find($id);
        if ($result == null) {
            return response()->json(['error' => 'Registro não encontrado.'], 404);
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
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->product->find($id);
            if ($result == null) {
                return response()->json(['error' => 'Registro não foi atualizado.'], 404);
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
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
            $result = $this->product->find($id);
            if ($result == null) {
                return response()->json(['error' => 'Registro não pode ser deletado.'], 404);
            } else {
                $result->delete();
                return response()->json(['MSG' => 'Registro deletado com sucesso!'], 200);
            }
        } else {
            return response()->json(['error' => 'Acesso negado!'], 403);
        }
    }
}
