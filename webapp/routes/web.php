<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');



//Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);


// Route::get('/users', [App\Http\Controllers\UserController::class, 'index']);

Route::get('/users', 'App\Http\Controllers\UserController@index');
Route::get('/users-update/{id}', 'App\Http\Controllers\UserController@update');
//Route::post('/users', 'App\Http\Controllers\UserController@index');
Route::post('/users-create', [App\Http\Controllers\UserController::class, 'store'])->name('store');
Route::get('/users-create', 'App\Http\Controllers\UserController@create');
//Route::post('/user-detail', [App\Http\Controllers\UserController::class, 'editUser'])->name('editUser');

//Route::resource('users','App\Http\Controllers\UserController@index');

