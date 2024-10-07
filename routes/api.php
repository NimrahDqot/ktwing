<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VolunteerController;
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
    Route::post('login', [VolunteerController::class, 'login']);
    Route::post('profile', [VolunteerController::class, 'profile']);
    Route::get('app-string', [VolunteerController::class, 'app_string']);
    Route::get('banner', [VolunteerController::class, 'banner']);
    Route::post('notification', [VolunteerController::class, 'notification']);
    Route::post('visitor-form', [VolunteerController::class, 'store_visitor']);
    Route::post('all-event', [VolunteerController::class, 'all_events']);
    Route::post('event-detail', [VolunteerController::class, 'event_detail']);
    Route::post('create-event-request', [VolunteerController::class, 'create_event_request']);
    Route::post('event-medias', [VolunteerController::class, 'event_medias']);
    Route::post('refer-user-list', [VolunteerController::class, 'refer_list']);
});

Route::group(['prefix' => 'user'], function () {
    Route::post('login', [UserController::class, 'login']);
    Route::post('profile', [UserController::class, 'profile']);
    Route::post('update-profile', [UserController::class, 'update_profile']);

});
