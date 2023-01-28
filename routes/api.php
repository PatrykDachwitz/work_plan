<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DaysController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\EventController;

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
Route::group([
    'namespace' => "App\Http\Controllers\Api",
    "prefix" => "/user/{id}",
    "as" => "user.change."
], function() {
    Route::put('/role', "UserController@changeRole")
    ->name('role');
    Route::put('/group', "UserController@changeGroup")
    ->name('group');
});
Route::resource('days', DaysController::class);
Route::resource('status', StatusController::class)
->middleware('auth.token');
Route::resource('notification', NotificationController::class);
Route::resource('event', EventController::class);
