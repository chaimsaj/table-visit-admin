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

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

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

//Reservations
//Bookings
Route::get('/bookings', [App\Http\Controllers\BookingsController::class, 'index'])->name('bookings');
Route::get('/booking/{id}', [App\Http\Controllers\BookingsController::class, 'detail'])->name('booking.detail');
Route::post('/booking/{id}', [App\Http\Controllers\BookingsController::class, 'save'])->name('booking.save');
Route::get('/booking/delete/{id}', [App\Http\Controllers\BookingsController::class, 'delete'])->name('booking.delete');

//Payments
Route::get('/payments', [App\Http\Controllers\PaymentsController::class, 'index'])->name('payments');
Route::get('/payment/{id}', [App\Http\Controllers\PaymentsController::class, 'detail'])->name('payment.detail');
Route::post('/payment/{id}', [App\Http\Controllers\PaymentsController::class, 'save'])->name('payment.save');
Route::get('/payment/delete/{id}', [App\Http\Controllers\PaymentsController::class, 'delete'])->name('payment.delete');

//Sample
Route::get('/samples', [App\Http\Controllers\SamplesController::class, 'index'])->name('samples');
Route::get('/sample/{id}', [App\Http\Controllers\SamplesController::class, 'detail'])->name('sample.detail');
Route::post('/sample/{id}', [App\Http\Controllers\SamplesController::class, 'save'])->name('sample.save');
Route::get('/sample/delete/{id}', [App\Http\Controllers\SamplesController::class, 'delete'])->name('sample.delete');

//Contents
Route::get('/content/lock-screen', [App\Http\Controllers\ContentsController::class, 'lockScreen'])->name('content.lock-screen');
Route::post('/content/terms', [App\Http\Controllers\SamplesController::class, 'terms'])->name('content.terms');

//Users
Route::get('/users', [App\Http\Controllers\UsersController::class, 'index'])->name('users');
Route::get('/user/{id}', [App\Http\Controllers\UsersController::class, 'detail'])->name('user.detail');
Route::post('/user/{id}', [App\Http\Controllers\UsersController::class, 'save'])->name('user.save');
Route::get('/user/delete/{id}', [App\Http\Controllers\UsersController::class, 'delete'])->name('user.delete');
Route::post('/user/save_user_to_place/{id}', [App\Http\Controllers\UsersController::class, 'save_user_to_place'])->name('user.save_user_to_place');
Route::get('/user/delete_user_to_place/{id}', [App\Http\Controllers\UsersController::class, 'delete_user_to_place'])->name('user.delete_user_to_place');

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
Route::post('/place/save_details/{id}', [App\Http\Controllers\PlacesController::class, 'save_details'])->name('place.save_details');
Route::post('/place/save_floor_plan/{id}', [App\Http\Controllers\PlacesController::class, 'save_floor_plan'])->name('place.save_floor_plan');
Route::post('/place/save_food_menu/{id}', [App\Http\Controllers\PlacesController::class, 'save_food_menu'])->name('place.save_food_menu');

Route::post('/place/save_feature_to_place/{id}', [App\Http\Controllers\PlacesController::class, 'save_feature_to_place'])->name('place.save_feature_to_place');
Route::get('/place/delete_feature_to_place/{id}', [App\Http\Controllers\PlacesController::class, 'delete_feature_to_place'])->name('place.delete_feature_to_place');

Route::post('/place/save_music_to_place/{id}', [App\Http\Controllers\PlacesController::class, 'save_music_to_place'])->name('place.save_music_to_place');
Route::get('/place/delete_music_to_place/{id}', [App\Http\Controllers\PlacesController::class, 'delete_music_to_place'])->name('place.delete_music_to_place');

//Place Types
Route::get('/place-types', [App\Http\Controllers\PlaceTypesController::class, 'index'])->name('place-types');
Route::get('/place-type/{id}', [App\Http\Controllers\PlaceTypesController::class, 'detail'])->name('place-type.detail');
Route::post('/place-type/{id}', [App\Http\Controllers\PlaceTypesController::class, 'save'])->name('place-type.save');
Route::get('/place-type/delete/{id}', [App\Http\Controllers\PlaceTypesController::class, 'delete'])->name('place-type.delete');

//Place Features
Route::get('/place-features', [App\Http\Controllers\PlaceFeaturesController::class, 'index'])->name('place-features');
Route::get('/place-feature/{id}', [App\Http\Controllers\PlaceFeaturesController::class, 'detail'])->name('place-feature.detail');
Route::post('/place-feature/{id}', [App\Http\Controllers\PlaceFeaturesController::class, 'save'])->name('place-feature.save');
Route::get('/place-feature/delete/{id}', [App\Http\Controllers\PlaceFeaturesController::class, 'delete'])->name('place-feature.delete');

//Place Music
Route::get('/place-music-list', [App\Http\Controllers\PlaceMusicController::class, 'index'])->name('place-music-list');
Route::get('/place-music/{id}', [App\Http\Controllers\PlaceMusicController::class, 'detail'])->name('place-music.detail');
Route::post('/place-music/{id}', [App\Http\Controllers\PlaceMusicController::class, 'save'])->name('place-music.save');
Route::get('/place-music/delete/{id}', [App\Http\Controllers\PlaceMusicController::class, 'delete'])->name('place-music.delete');

//Logs
Route::get('/logs', [App\Http\Controllers\LogController::class, 'index'])->name('logs');
Route::get('/log/{id}', [App\Http\Controllers\LogController::class, 'detail'])->name('log.detail');
Route::get('/log/delete/{id}', [App\Http\Controllers\LogController::class, 'delete'])->name('log.delete');

//Services
//Services
Route::get('/services', [App\Http\Controllers\ServicesController::class, 'index'])->name('services');
Route::get('/service/{id}', [App\Http\Controllers\ServicesController::class, 'detail'])->name('service.detail');
Route::post('/service/{id}', [App\Http\Controllers\ServicesController::class, 'save'])->name('service.save');
Route::get('/service/delete/{id}', [App\Http\Controllers\ServicesController::class, 'delete'])->name('service.delete');
