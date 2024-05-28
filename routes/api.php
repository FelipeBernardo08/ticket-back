<?php

use App\Http\Controllers\AtractionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
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
    Route::put('update-categories/{id}', [CategoryController::class, 'updateCategory']);
    Route::delete('delete-categories/{id}', [CategoryController::class, 'deleteCategory']);

    //event
    Route::post('create-event', [EventController::class, 'createEvents']);
    Route::put('update-event/{id}', [EventController::class, 'updateEvent']);
    Route::delete('delete-event/{id}', [EventController::class, 'deleteEvent']);

    //product
    Route::post('create-product', [ProductController::class, 'createProduct']);
    Route::put('update-product/{id}', [ProductController::class, 'updateProduct']);
    Route::delete('delete-product/{id}', [ProductController::class, 'deleteProduct']);
});

//rotas abertas

//login
Route::post('login', [AuthController::class, 'login']);

//atraction
Route::get('read-atractions', [AtractionController::class, 'readAtractions']);
Route::get('read-atractions-events', [AtractionController::class, 'readAtractionsWithEvent']);
Route::get('read-atraction/{id}', [AtractionController::class, 'showAtractionId']);
Route::get('read-atraction-events/{id}', [AtractionController::class, 'showAtractionIdWithEvent']);

//category
Route::get('read-categories', [CategoryController::class, 'readCategories']);
Route::get('read-categories-products', [CategoryController::class, 'readCategoriesWithProducts']);
Route::get('read-category/{id}', [CategoryController::class, 'showCategoryId']);
Route::get('read-category-products/{id}', [CategoryController::class, 'showCategoryIdWithProducts']);

//event
Route::get('read-events', [EventController::class, 'readEvents']);
Route::get('read-events-atractions', [EventController::class, 'readEventsWithAtraction']);
Route::get('read-event/{id}', [EventController::class, 'showEventId']);
Route::get('read-event-atraction/{id}', [EventController::class, 'showEventIdWithAtractions']);

//product
Route::get('read-products', [ProductController::class, 'readProducts']);
Route::get('read-products-categories', [ProductController::class, 'readProductsWithCategories']);
Route::get('read-products/{id}', [ProductController::class, 'showProductId']);
Route::get('read-products-category/{id}', [ProductController::class, 'showProductIdWithCategory']);
