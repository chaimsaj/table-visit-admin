<?php


use App\Http\Api\CountryController;
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
    //Route::resource('countries', CountryController::class);

    Route::get('countries/list', 'App\Http\Api\CountryController@list');
    Route::get('countries/find/{id}', 'App\Http\Api\CountryController@find');
});
