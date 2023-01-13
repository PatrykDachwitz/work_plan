<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HomePage;
use \App\Http\Controllers\StatusController;
use \App\Http\Controllers\CalendarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', HomePage::class);
Route::resource('/day', StatusController::class);
Route::get('/calendar', CalendarController::class)
->name('calendar.index');
