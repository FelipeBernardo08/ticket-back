<?php

use App\Http\Controllers\AtractionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ImageEventController;
use App\Http\Controllers\ImageTicketController;
use App\Http\Controllers\PassListController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\TicketController;
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
    //log
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);

    //permission
    Route::apiResource('permission', PermissionController::class);

    //user
    Route::post('create-user', [Controller::class, 'createUser']);

    //atraction
    Route::post('create-atraction', [AtractionController::class, 'createAtraction']);
    Route::put('update-atraction/{id}', [AtractionController::class, 'updateAtraction']);
    Route::delete('delete-atraction/{id}', [AtractionController::class, 'deleteAtraction']);

    //category
    Route::post('create-category', [CategoryController::class, 'createCategory']);
    Route::put('update-category/{id}', [CategoryController::class, 'updateCategory']);
    Route::delete('delete-category/{id}', [CategoryController::class, 'deleteCategory']);

    //event
    Route::post('create-event', [EventController::class, 'createEvents']);
    Route::put('update-event/{id}', [EventController::class, 'updateEvent']);
    Route::delete('delete-event/{id}', [EventController::class, 'deleteEvent']);

    //sell
    Route::get('read-sells', [SellController::class, 'readSells']);
    Route::get('read-sells-user-ticket', [SellController::class, 'readSellsWithUserAndTicket']);
    Route::get('read-sell/{id}', [SellController::class, 'readSellId']);
    Route::post('create-sell', [SellController::class, 'createSell']);
    Route::put('update-sell/{id}', [SellController::class, 'updateSell']);

    //ticket
    Route::post('create-ticket', [TicketController::class, 'createTicket']);
    Route::put('update-ticket/{id}', [TicketController::class, 'updateTicket']);
    Route::delete('delete-ticket/{id}', [TicketController::class, 'deleteTicket']);

    //show
    Route::post('create-show', [ShowController::class, 'createShow']);
    Route::put('update-show/{id}', [ShowController::class, 'updateShow']);
    Route::delete('delete-show/{id}', [ShowController::class, 'deleteShow']);

    //imgEvent
    Route::post('create-img-event', [ImageEventController::class, 'createImgEvent']);
    Route::delete('delete-img-event/{id}', [ImageEventController::class, 'deleteImgEvent']);

    //imgTicket
    Route::post('create-img-ticket', [ImageTicketController::class, 'createImgTicket']);
    Route::delete('delete-img-ticket/{id}', [ImageTicketController::class, 'deleteImgProduct']);

    //passList
    Route::get('read-list', [PassListController::class, 'readList']);
    Route::get('read-list-event/{id}', [PassListController::class, 'readListIdEvent']);
    Route::post('create-list', [PassListController::class, 'createList']);
    Route::delete('delete-list/{id}', [PassListController::class, 'deleteList']);
});

//rotas publicas

//login
Route::post('login', [AuthController::class, 'login']);

//atraction
Route::get('read-atractions', [AtractionController::class, 'readAtractions']);
Route::get('read-atractions-show', [AtractionController::class, 'readAtractionsWithShow']);
Route::get('read-atraction/{id}', [AtractionController::class, 'showAtractionId']);

//category
Route::get('read-categories', [CategoryController::class, 'readCategories']);
Route::get('read-categories-products', [CategoryController::class, 'readCategoriesWithProducts']);
Route::get('read-category/{id}', [CategoryController::class, 'showCategoryId']);


//event
Route::get('read-events', [EventController::class, 'readEvents']);
Route::get('read-event/{id}', [EventController::class, 'showEventId']);


//ticket
Route::get('read-tickets', [TicketController::class, 'readTikects']);
Route::get('read-tickets-events', [TicketController::class, 'readTikectsWithEvent']);
Route::get('read-ticket/{id}', [TicketController::class, 'readTicketId']);

//show
Route::get('read-shows', [ShowController::class, 'readShows']);
Route::get('read-shows/{id}', [ShowController::class, 'readShowId']);

//imgEvent
Route::get('read-all-images-events', [ImageEventController::class, 'readAllImagesEvents']);
Route::get('read-images-events/{id}', [ImageEventController::class, 'readImagesEvents']);

//imgTicket
Route::get('read-img-ticket/{id}', [ImageTicketController::class, 'readImgTicket']);
