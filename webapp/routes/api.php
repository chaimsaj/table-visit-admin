<?php


use App\Http\Api\CountriesController;
use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->get('/health', function () {
    return "OK";
});

Route::middleware('api')->group(function () {
    Route::get('/users', [App\Http\Api\UsersController::class, 'list'])->name('api.users');

    Route::get('/cities', [App\Http\Api\CitiesController::class, 'list'])->name('api.cities');
    Route::get('/city/{id}', [App\Http\Api\CitiesController::class, 'find'])->name('api.city.find');
});
