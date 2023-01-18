<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HomePage;
use \App\Http\Controllers\StatusController;
use \App\Http\Controllers\CalendarController;
use \App\Http\Controllers\Auth\RegisterController;
use \App\Http\Controllers\Auth\LoginController;

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
Route::middleware('auth')
    ->group(function (){
    Route::get('/', HomePage::class)
    ->name('dashboard');
    Route::get('/calendar', CalendarController::class)
        ->name('calendar.index');
    Route::resource('/day', StatusController::class);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
        ->name('register');
    Route::get('/logout', [LoginController::class, 'logout'])
    ->name('logout');
    Route::group([
        'namespace' => "\App\Http\Controllers",
        'as' => 'user.',
        'prefix' => 'user'
    ], function() {
        Route::post('/register', 'UserController@store')
            ->name('register');
        Route::get('/', 'UserController@index')
            ->name('index');
        Route::get('/show', 'UserController@show')
            ->name('show');
        Route::get('/create', 'UserController@create')
            ->name('create');
        Route::get('/{id}', 'UserController@edit')
            ->name('edit');
        Route::post('/{id}', 'UserController@update')
            ->name('update');
    });
});

Route::post('/login', [LoginController::class, 'login'])
    ->name('login');
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');
