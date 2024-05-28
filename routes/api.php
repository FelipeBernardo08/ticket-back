<?php

use App\Http\Controllers\AtractionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\TicketController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//grupo de rota privada
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

    //sell
    Route::get('read-sells', [SellController::class, 'readSells']);
    Route::get('read-sells-user-ticket', [SellController::class, 'readSellsWithUserAndTicket']);
    Route::get('read-sell/{id}', [SellController::class, 'readSellId']);
    Route::get('read-sell-user-ticket/{id}', [SellController::class, 'readSellIdWithUserAndTicket']);
    Route::post('create-sell', [SellController::class, 'createSell']);
    Route::put('update-sell/{id}', [SellController::class, 'updateSell']);

    //table
    Route::post('create-table', [TableController::class, 'createTable']);
    Route::get('read-table/{id}', [TableController::class, 'readTableId']);
    Route::put('update-table/{id}', [TableController::class, 'updateTable']);
    Route::delete('delete-table/{id}', [TableController::class, 'deleteTable']);

    //ticket
    Route::post('create-ticket', [TicketController::class, 'createTicket']);
    Route::put('update-ticket/{id}', [TicketController::class, 'updateTicket']);
    Route::delete('delete-ticket/{id}', [TicketController::class, 'deleteTicket']);
});

//rotas publicas

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
Route::get('read-product/{id}', [ProductController::class, 'showProductId']);
Route::get('read-product-category/{id}', [ProductController::class, 'showProductIdWithCategory']);

//table
Route::get('read-tables', [TableController::class, 'readTables']);

//ticket
Route::get('read-tickets', [TicketController::class, 'readTikects']);
Route::get('read-tickets-events', [TicketController::class, 'readTikectsWithEvent']);
Route::get('read-ticket/{id}', [TicketController::class, 'readTicketId']);
