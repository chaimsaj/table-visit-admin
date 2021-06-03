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
//Route::get('/users', [App\Http\Controllers\UsersController::class, 'index'])->name('users');
//Route::get('/user/{id}', [App\Http\Controllers\UsersController::class, 'edit'])->name('user.edit');
//Route::get('/user/create', [App\Http\Controllers\UsersController::class, 'create'])->name('user.create');
//Route::post('/user/update', [App\Http\Controllers\UsersController::class, 'update'])->name('user.update');

//Sample
Route::get('/samples', [App\Http\Controllers\SamplesController::class, 'index'])->name('samples');
Route::get('/sample/{id}', [App\Http\Controllers\SamplesController::class, 'detail'])->name('sample.detail');
Route::post('/sample/{id}', [App\Http\Controllers\SamplesController::class, 'save'])->name('sample.save');
Route::get('/sample/delete/{id}', [App\Http\Controllers\SamplesController::class, 'delete'])->name('sample.delete');

//Users
Route::get('/users', [App\Http\Controllers\UsersController::class, 'index'])->name('users');
Route::get('/user/{id}', [App\Http\Controllers\UsersController::class, 'detail'])->name('user.detail');
Route::post('/user/{id}', [App\Http\Controllers\UsersController::class, 'save'])->name('user.save');
Route::get('/user/delete/{id}', [App\Http\Controllers\UsersController::class, 'delete'])->name('user.delete');

//UserTypes
Route::get('/user-types', [App\Http\Controllers\UserTypesController::class, 'index'])->name('user-types');
Route::get('/user-type/{id}', [App\Http\Controllers\UserTypesController::class, 'detail'])->name('user-type.detail');
Route::post('/user-type/{id}', [App\Http\Controllers\UserTypesController::class, 'save'])->name('user-type.save');
Route::get('/user-type/delete/{id}', [App\Http\Controllers\UserTypesController::class, 'delete'])->name('user-type.delete');

//Locations
//Countries
Route::get('/countries', [App\Http\Controllers\CountriesController::class, 'index'])->name('countries');
Route::get('/country/{id}', [App\Http\Controllers\CountriesController::class, 'detail'])->name('country.detail');
Route::post('/country/{id}', [App\Http\Controllers\CountriesController::class, 'save'])->name('country.save');
Route::get('/country/delete/{id}', [App\Http\Controllers\CountriesController::class, 'delete'])->name('country.delete');

//States
Route::get('/states', [App\Http\Controllers\StatesController::class, 'index'])->name('states');
Route::get('/state/{id}', [App\Http\Controllers\StatesController::class, 'detail'])->name('state.detail');
Route::post('/state/{id}', [App\Http\Controllers\StatesController::class, 'save'])->name('state.save');
Route::get('/state/delete/{id}', [App\Http\Controllers\StatesController::class, 'delete'])->name('state.delete');

//Cities
Route::get('/cities', [App\Http\Controllers\CitiesController::class, 'index'])->name('cities');
Route::get('/city/{id}', [App\Http\Controllers\CitiesController::class, 'detail'])->name('city.detail');
Route::post('/city/{id}', [App\Http\Controllers\CitiesController::class, 'save'])->name('city.save');
Route::get('/city/delete/{id}', [App\Http\Controllers\CitiesController::class, 'delete'])->name('city.delete');

//Localization
//Languages
Route::get('/languages', [App\Http\Controllers\LanguagesController::class, 'index'])->name('languages');
Route::get('/language/{id}', [App\Http\Controllers\LanguagesController::class, 'detail'])->name('language.detail');
Route::post('/language/{id}', [App\Http\Controllers\LanguagesController::class, 'save'])->name('language.save');
Route::get('/language/delete/{id}', [App\Http\Controllers\LanguagesController::class, 'delete'])->name('language.delete');

//Currencies
Route::get('/currencies', [App\Http\Controllers\CurrenciesController::class, 'index'])->name('currencies');
Route::get('/currency/{id}', [App\Http\Controllers\CurrenciesController::class, 'detail'])->name('currency.detail');
Route::post('/currency/{id}', [App\Http\Controllers\CurrenciesController::class, 'save'])->name('currency.save');
Route::get('/currency/delete/{id}', [App\Http\Controllers\CurrenciesController::class, 'delete'])->name('currency.delete');

//Venues
//Places
Route::get('/places', [App\Http\Controllers\PlacesController::class, 'index'])->name('places');
Route::get('/place/{id}', [App\Http\Controllers\PlacesController::class, 'detail'])->name('place.detail');
Route::post('/place/{id}', [App\Http\Controllers\PlacesController::class, 'save'])->name('place.save');
Route::get('/place/delete/{id}', [App\Http\Controllers\PlacesController::class, 'delete'])->name('place.delete');

//PlaceTypes
Route::get('/place-types', [App\Http\Controllers\PlaceTypesController::class, 'index'])->name('place-types');
Route::get('/place-type/{id}', [App\Http\Controllers\PlaceTypesController::class, 'detail'])->name('place-type.detail');
Route::post('/place-type/{id}', [App\Http\Controllers\PlaceTypesController::class, 'save'])->name('place-type.save');
Route::get('/place-type/delete/{id}', [App\Http\Controllers\PlaceTypesController::class, 'delete'])->name('place-type.delete');
