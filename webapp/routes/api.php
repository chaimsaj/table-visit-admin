<?php

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

Route::middleware('api')->group(function () {
    // Locations
    Route::get('/admin/locations/load_states/{country_id}', [App\Http\AdminApi\LocationsController::class, 'load_states'])->name('admin_api.locations.load_states');
    Route::get('/admin/locations/load_cities/{state_id}', [App\Http\AdminApi\LocationsController::class, 'load_cities'])->name('admin_api.locations.load_cities');
    Route::post('/admin/locations/cities', [App\Http\AdminApi\LocationsController::class, 'cities'])->name('admin_api.locations.cities');

    // Places
    Route::post('/admin/places/list', [App\Http\AdminApi\PlacesController::class, 'list'])->name('admin_api.places.list');

    // Tables
    Route::post('/admin/tables/list', [App\Http\AdminApi\TablesController::class, 'list'])->name('admin_api.tables.list');

    // Services
    Route::post('/admin/services/list', [App\Http\AdminApi\ServicesController::class, 'list'])->name('admin_api.services.list');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/sign_out', [App\Http\Api\AuthController::class, 'sign_out'])->name('api.auth.sign_out');
    Route::get('/logged_user', [App\Http\Api\AuthController::class, 'logged_user'])->name('api.auth.logged_user');
    Route::get('/valid_user', [App\Http\Api\AuthController::class, 'valid_user'])->name('api.auth.valid_user');

    Route::get('/countries', [App\Http\Api\CountriesController::class, 'list'])->name('api.countries.list');
    Route::get('/country/{id}', [App\Http\Api\CountriesController::class, 'find'])->name('api.countries.find');

    Route::get('/states', [App\Http\Api\StatesController::class, 'list'])->name('api.states.list');
    Route::get('/state/{id}', [App\Http\Api\StatesController::class, 'find'])->name('api.states.find');

    Route::get('/cities', [App\Http\Api\CitiesController::class, 'list'])->name('api.cities.list');
    Route::get('/city/{id}', [App\Http\Api\CitiesController::class, 'find'])->name('api.cities.find');
    Route::post('/cities/search', [App\Http\Api\CitiesController::class, 'search'])->name('api.cities.search');
    Route::get('/cities/top', [App\Http\Api\CitiesController::class, 'top'])->name('api.cities.top');

    Route::get('/places', [App\Http\Api\PlacesController::class, 'list'])->name('api.places.list');
    Route::get('/places/featured', [App\Http\Api\PlacesController::class, 'featured'])->name('api.places.featured');
    Route::get('/places/near', [App\Http\Api\PlacesController::class, 'near'])->name('api.places.near');
    Route::get('/places/near', [App\Http\Api\PlacesController::class, 'near'])->name('api.places.near');
    Route::get('/place/{id}', [App\Http\Api\PlacesController::class, 'find'])->name('api.places.find');
    Route::get('/places/near_by_city/{city_id}', [App\Http\Api\PlacesController::class, 'near_by_city'])->name('api.places.near_by_city');
    Route::post('/places/search', [App\Http\Api\PlacesController::class, 'search'])->name('api.places.search');

    Route::get('/place_music', [App\Http\Api\PlaceMusicController::class, 'list'])->name('api.place_music.list');
    Route::get('/place_music/{id}', [App\Http\Api\PlaceMusicController::class, 'find'])->name('api.place_music.find');

    Route::get('/place_features', [App\Http\Api\PlaceFeaturesController::class, 'list'])->name('api.place_features.list');
    Route::get('/place_feature/{id}', [App\Http\Api\PlaceFeaturesController::class, 'find'])->name('api.place_features.find');

    // Services
    Route::get('/services/rates/{place_id}', [App\Http\Api\ServicesController::class, 'rates'])->name('api.services.rates');

    // Tables
    Route::get('/tables/{place_id}', [App\Http\Api\TablesController::class, 'list'])->name('api.tables.list');
    Route::post('/tables/rates', [App\Http\Api\TablesController::class, 'rates'])->name('api.tables.rates');
    Route::post('/tables/rate', [App\Http\Api\TablesController::class, 'rate'])->name('api.tables.rate');

    // Favorites
    Route::get('/user/favorites', [App\Http\Api\FavoritesController::class, 'list'])->name('api.user.favorites.list');
    Route::get('/user/favorite/add/{place_id}', [App\Http\Api\FavoritesController::class, 'add'])->name('api.user.favorites.add');
    Route::get('/user/favorite/remove/{rel_id}', [App\Http\Api\FavoritesController::class, 'remove'])->name('api.user.favorites.remove');

    // Policies
    Route::get('/place_policies/{place_id}', [App\Http\Api\PoliciesController::class, 'list'])->name('api.place_policies.list');
    Route::get('/place_policy/{place_id}/{policy_type}', [App\Http\Api\PoliciesController::class, 'load_by_type'])->name('api.place_policies.load_by_type');

    // Ratings
    Route::get('/user/ratings', [App\Http\Api\RatingsController::class, 'list'])->name('api.user.ratings.list');
    Route::get('/user/rating/add/{place_id}', [App\Http\Api\RatingsController::class, 'add'])->name('api.user.ratings.add');
    Route::get('/user/rating/remove/{rel_id}', [App\Http\Api\RatingsController::class, 'remove'])->name('api.user.ratings.remove');

    // Reviews
    Route::get('/user/reviews', [App\Http\Api\ReviewsController::class, 'list'])->name('api.user.reviews.list');
    Route::get('/user/review/add/{place_id}', [App\Http\Api\ReviewsController::class, 'add'])->name('api.user.reviews.add');
    Route::get('/user/review/remove/{rel_id}', [App\Http\Api\ReviewsController::class, 'remove'])->name('api.user.reviews.remove');

    // Bookings
    Route::get('/user/bookings', [App\Http\Api\BookingsController::class, 'list'])->name('api.user.bookings.list');
    Route::post('/user/booking/book', [App\Http\Api\BookingsController::class, 'book'])->name('api.user.bookings.book');
    Route::post('/user/booking/cancel', [App\Http\Api\BookingsController::class, 'cancel'])->name('api.user.bookings.cancel');
});
