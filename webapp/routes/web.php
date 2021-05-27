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
Route::get('/index', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

//Update User Details
//Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
//Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');
//Route::get('/users', 'App\Http\Controllers\UserController@index');
//Route::post('/users-create', [App\Http\Controllers\UserController::class, 'store'])->name('store');
//Route::get('/users-create', 'App\Http\Controllers\UserController@create');
//Route::post('/users-edit', [App\Http\Controllers\UserController::class, 'update'])->name('update');
//Route::get('/users-edit/{id}', 'App\Http\Controllers\UserController@edit');

//Users
Route::get('/users', [App\Http\Controllers\UsersController::class, 'index'])->name('users');
Route::get('/user/{id}', [App\Http\Controllers\UsersController::class, 'edit'])->name('user.edit');
Route::get('/user/create', [App\Http\Controllers\UsersController::class, 'create'])->name('user.create');
Route::post('/user/update', [App\Http\Controllers\UsersController::class, 'update'])->name('user.update');

//Countries
Route::get('/countries', [App\Http\Controllers\CountriesController::class, 'index'])->name('countries');
Route::get('/country/{id}', [App\Http\Controllers\CountriesController::class, 'detail'])->name('country.detail');
Route::post('/country/{id}', [App\Http\Controllers\CountriesController::class, 'save'])->name('country.save');

//Sample
Route::get('/samples', [App\Http\Controllers\SamplesController::class, 'index'])->name('samples');
Route::get('/sample/{id}', [App\Http\Controllers\SamplesController::class, 'detail'])->name('sample.detail');
Route::post('/sample/{id}', [App\Http\Controllers\SamplesController::class, 'save'])->name('sample.save');
Route::get('/sample/delete/{id}', [App\Http\Controllers\SamplesController::class, 'delete'])->name('sample.delete');
