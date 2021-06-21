<?php


use App\AppModels\ApiModel;
use App\Core\ApiCodeEnum;
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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

/*Route::middleware('api')->get('/health', function () {

});*/

Route::middleware('api')->group(function () {
    Route::get('/health', [App\Http\Api\MainController::class, 'health'])->name('api.main.health');

    Route::post('/sign_in', [App\Http\Api\AuthController::class, 'sign_in'])->name('api.auth.sign_in');
    Route::post('/sign_up', [App\Http\Api\AuthController::class, 'sign_up'])->name('api.auth.sign_up');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/sign_out', [App\Http\Api\AuthController::class, 'sign_out'])->name('api.auth.sign_out');

    Route::get('/users', [App\Http\Api\UsersController::class, 'list'])->name('api.users.list');

    Route::get('/cities', [App\Http\Api\CitiesController::class, 'list'])->name('api.cities.list');
    Route::get('/city/{id}', [App\Http\Api\CitiesController::class, 'find'])->name('api.cities.find');
});
