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

    //Admin Api
    //Locations
    Route::get('/admin/locations/load_states/{country_id}', [App\Http\AdminApi\LocationsController::class, 'load_states'])->name('admin.api.load_states');
    Route::get('/admin/locations/load_cities/{state_id}', [App\Http\AdminApi\LocationsController::class, 'load_cities'])->name('admin.api.load_cities');

    //Route::get('/admin/main/import', [App\Http\AdminApi\MainController::class, 'import'])->name('admin.api.main.import');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/sign_out', [App\Http\Api\AuthController::class, 'sign_out'])->name('api.auth.sign_out');
    Route::get('/logged_user', [App\Http\Api\AuthController::class, 'logged_user'])->name('api.auth.logged_user');
    Route::get('/valid_user', [App\Http\Api\AuthController::class, 'valid_user'])->name('api.auth.valid_user');

    Route::get('/cities', [App\Http\Api\CitiesController::class, 'list'])->name('api.cities.list');
    Route::get('/city/{id}', [App\Http\Api\CitiesController::class, 'find'])->name('api.cities.find');

    Route::get('/cities', [App\Http\Api\CitiesController::class, 'list'])->name('api.cities.list');
    Route::get('/city/{id}', [App\Http\Api\CitiesController::class, 'find'])->name('api.cities.find');
});
