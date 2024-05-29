<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;

class PermissionController extends Controller
{
    private $authController;
    public $permission;

    public function __construct(AuthController $auth, Permission $permissions)
    {
        $this->authController = $auth;
        $this->permission = $permissions;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = $this->authController->me();
        if ($auth->id_permission == 2) {
            $result = $this->permission->all();
            if (count($result) == 0) {
                return response()->json(['error' => 'Não existem registros cadastrados!'], 404);
            } else {
                return response()->json($result, 200);
            }
        } else {
            return response()->json(['error' => 'Acesso negado!'], 401);
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
        if ($auth->id_permission == 2) {
            $result = $this->create($request->all());
            if ($result == null) {
                return response()->json(['error' => 'Não existem registros cadastrados!'], 404);
            } else {
                return response()->json($result, 200);
            }
        } else {
            return response()->json(['error' => 'Acesso negado!'], 401);
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
        $auth = $this->authController->me();
        if ($auth->id_permission == 2) {
            $result = $this->permission->find($id);
            if ($result == null) {
                return response()->json(['error' => 'Não existem registros cadastrados!'], 404);
            } else {
                return response()->json($result, 200);
            }
        } else {
            return response()->json(['error' => 'Acesso negado!'], 401);
        }
    }
}
