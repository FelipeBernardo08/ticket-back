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
        if ($auth->id_permission == 2 || $auth->id_permission == 3) {
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
}
