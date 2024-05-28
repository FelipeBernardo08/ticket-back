<?php

use App\Http\Controllers\AtractionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('jwt.auth')->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);

    //permission
    Route::apiResource('permission', PermissionController::class);

    //atraction
    Route::post('create-atraction', [AtractionController::class, 'createAtraction']);
    Route::put('update-atraction/{id}', [AtractionController::class, 'updateAtraction']);
    Route::delete('delete-atraction/{id}', [AtractionController::class, 'deleteAtraction']);

    //category
    Route::post('create-categories', [CategoryController::class, 'createCategory']);
    Route::post('update-categories/{id}', [CategoryController::class, 'updateCategory']);
    Route::post('delete-categories/{id}', [CategoryController::class, 'deleteCategory']);
});

//rotas abertas

//login
Route::post('login', [AuthController::class, 'login']);

//atraction
Route::get('read-atraction', [AtractionController::class, 'readAtractions']);
Route::get('read-atraction-events', [AtractionController::class, 'readAtractionsWithEvent']);
Route::get('read-atraction/{id}', [AtractionController::class, 'showAtractionId']);
Route::get('read-atraction-events/{id}', [AtractionController::class, 'showAtractionIdWithEvent']);

//category
Route::get('read-categories', [CategoryController::class, 'readCategories']);
Route::get('read-categories-products', [CategoryController::class, 'readCategoriesWithProducts']);
Route::get('read-categories/{id}', [CategoryController::class, 'showCategoryId']);
Route::get('read-categories-products/{id}', [CategoryController::class, 'showCategoryIdWithProducts']);
