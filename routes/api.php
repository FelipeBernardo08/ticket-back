<?php

use App\Http\Controllers\AtractionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardPaymentsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ImageEventController;
use App\Http\Controllers\ImageTicketController;
use App\Http\Controllers\PassListController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Models\Permission;
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

    //atraction
    Route::get('read-atraction-with-sells', [AtractionController::class, 'readAtrctionWithEventAndSell']);
    Route::get('read-atractions', [AtractionController::class, 'readAtractions']);
    Route::get('read-atraction/{id}', [AtractionController::class, 'showAtractionId']);
    Route::post('create-atraction', [AtractionController::class, 'createAtraction']);
    Route::put('update-atraction/{id}', [AtractionController::class, 'updateAtraction']);
    Route::delete('delete-atraction/{id}', [AtractionController::class, 'deleteAtraction']);

    //event
    Route::get('read-events', [EventController::class, 'readEvents']);
    Route::get('read-event-date/{data}', [EventController::class, 'readEventsDate']);
    Route::post('create-event', [EventController::class, 'createEvents']);
    Route::put('update-event/{id}', [EventController::class, 'updateEvent']);
    Route::delete('delete-event/{id}', [EventController::class, 'deleteEvent']);
    Route::get('read-event-sells', [EventController::class, 'readEventsWithSells']);

    //sell
    Route::get('read-sells-token/{token}', [SellController::class, 'readSellsToken']);
    Route::get('read-sells', [SellController::class, 'readSells']);
    Route::get('read-sells-user-ticket/{date}', [SellController::class, 'readSellsWithUserAndTicket']);
    Route::get('read-sell/{id}', [SellController::class, 'readSellId']);
    Route::post('create-sell', [SellController::class, 'createSell']);
    Route::put('update-validate-ticket/{id}', [SellController::class, 'validVerificated']);

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
    Route::get('read-tickets-events', [TicketController::class, 'readTikectsWithEvent']);
    Route::post('create-img-ticket', [ImageTicketController::class, 'createImgTicket']);
    Route::delete('delete-img-ticket/{id}', [ImageTicketController::class, 'deleteImgTicket']);

    //list
    Route::get('read-lists', [PassListController::class, 'readList']);
    Route::get('read-list-event/{id}', [PassListController::class, 'readListIdEvent']);
    Route::post('create-list', [PassListController::class, 'createList']);
    Route::delete('delete-list/{id}', [PassListController::class, 'deleteList']);

    //user
    Route::get('read-users', [UserController::class, 'readUsers']);
    Route::get('read-user/{id}', [UserController::class, 'readUserId']);
    Route::put('update-user/{id}', [UserController::class, 'updateUser']);
    Route::patch('update-self', [UserController::class, 'updateSelf']);
    Route::delete('delete-user/{id}', [UserController::class, 'deleteUser']);
    Route::post('create-user', [UserController::class, 'createUser']);
    Route::patch('update-pass', [UserController::class, 'updatePassword']);

    //cardPayment
    Route::post('create-card-payment', [CardPaymentsController::class, 'createCardPayment']);
    Route::post('update-card-payment/{id}', [CardPaymentsController::class, 'updateCardPayment']);
    Route::put('update-url-payment/{id}', [CardPaymentsController::class, 'updateLinkPayment']);
    Route::get('get-card-payment', [CardPaymentsController::class, 'getCardsPayment']);
    Route::get('get-qr-code/{token}', [CardPaymentsController::class, 'generateQrCode']);
});

//login
Route::post('login', [AuthController::class, 'login']);

//user
Route::post('create-client', [UserController::class, 'createClient']);

//event
Route::get('events-complete', [EventController::class, 'readEventsComplete']);
Route::get('read-event/{id}', [EventController::class, 'showEventId']);


Route::post('testPayment', [PermissionController::class], 'test');
