<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => 'volunteer'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('profile', [AuthController::class, 'profile']);
    Route::get('app-string', [AuthController::class, 'app_string']);
    Route::get('banner', [AuthController::class, 'banner']);
    Route::post('notification', [AuthController::class, 'notification']);
    Route::post('visitor-form', [AuthController::class, 'store_visitor']);
    Route::post('all-event', [AuthController::class, 'all_events']);
    Route::post('event-detail', [AuthController::class, 'event_detail']);
    Route::post('create-event-request', [AuthController::class, 'create_event_request']);
    Route::post('event-medias', [AuthController::class, 'event_medias']);
});

