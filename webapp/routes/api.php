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
    Route::get('/upload', [App\Http\Api\MainController::class, 'upload'])->name('api.main.upload');

    Route::post('/sign_in', [App\Http\Api\AuthController::class, 'sign_in'])->name('api.auth.sign_in');
    Route::post('/sign_up', [App\Http\Api\AuthController::class, 'sign_up'])->name('api.auth.sign_up');

    //Staff
    Route::post('/staff/sign_in', [App\Http\Api\Staff\AuthController::class, 'sign_in'])->name('api.staff.sign_in');
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

    // Places
    Route::post('/admin/bookings/list', [App\Http\AdminApi\BookingsController::class, 'list'])->name('admin_api.bookings.list');

    // Reports
    Route::post('/admin/reports/table-spends', [App\Http\AdminApi\ReportsController::class, 'table_spends'])->name('admin_api.reports.table_spends');
    Route::post('/admin/reports/commissions', [App\Http\AdminApi\ReportsController::class, 'commissions'])->name('admin_api.reports.commissions');
});

Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::get('/sign_out', [App\Http\Api\AuthController::class, 'sign_out'])->name('api.auth.sign_out');
    Route::get('/logged_user', [App\Http\Api\AuthController::class, 'logged_user'])->name('api.auth.logged_user');
    Route::get('/valid_user', [App\Http\Api\AuthController::class, 'valid_user'])->name('api.auth.valid_user');

    // Countries
    Route::get('/countries', [App\Http\Api\CountriesController::class, 'list'])->name('api.countries.list');
    Route::get('/country/{id}', [App\Http\Api\CountriesController::class, 'find'])->name('api.countries.find');

    // States
    Route::get('/states', [App\Http\Api\StatesController::class, 'list'])->name('api.states.list');
    Route::get('/state/{id}', [App\Http\Api\StatesController::class, 'find'])->name('api.states.find');

    // Cities
    Route::get('/cities', [App\Http\Api\CitiesController::class, 'list'])->name('api.cities.list');
    Route::get('/city/{id}', [App\Http\Api\CitiesController::class, 'find'])->name('api.cities.find');
    Route::post('/cities/search', [App\Http\Api\CitiesController::class, 'search'])->name('api.cities.search');
    Route::get('/cities/top', [App\Http\Api\CitiesController::class, 'top'])->name('api.cities.top');

    // Places
    Route::get('/places', [App\Http\Api\PlacesController::class, 'list'])->name('api.places.list');
    Route::get('/places/featured', [App\Http\Api\PlacesController::class, 'featured'])->name('api.places.featured');
    Route::get('/places/near', [App\Http\Api\PlacesController::class, 'near'])->name('api.places.near');
    Route::get('/places/near', [App\Http\Api\PlacesController::class, 'near'])->name('api.places.near');
    Route::get('/place/{id}', [App\Http\Api\PlacesController::class, 'find'])->name('api.places.find');
    Route::get('/places/near_by_city/{city_id}', [App\Http\Api\PlacesController::class, 'near_by_city'])->name('api.places.near_by_city');
    Route::post('/places/search', [App\Http\Api\PlacesController::class, 'search'])->name('api.places.search');
    Route::get('/places/featured_by_city/{city_id}', [App\Http\Api\PlacesController::class, 'featured_by_city'])->name('api.places.featured_by_city');


    // Place Music
    Route::get('/place_music', [App\Http\Api\PlaceMusicController::class, 'list'])->name('api.place_music.list');
    Route::get('/place_music/{id}', [App\Http\Api\PlaceMusicController::class, 'find'])->name('api.place_music.find');

    // Place Features
    Route::get('/place_features', [App\Http\Api\PlaceFeaturesController::class, 'list'])->name('api.place_features.list');
    Route::get('/place_feature/{id}', [App\Http\Api\PlaceFeaturesController::class, 'find'])->name('api.place_features.find');

    // Services
    Route::get('/services/rates/{place_id}', [App\Http\Api\ServicesController::class, 'rates'])->name('api.services.rates');

    // Tables
    Route::get('/tables/{place_id}', [App\Http\Api\TablesController::class, 'list'])->name('api.tables.list');
    Route::post('/tables/with-date', [App\Http\Api\TablesController::class, 'with_date'])->name('api.tables.with_date');
    Route::get('/table/{id}', [App\Http\Api\TablesController::class, 'find'])->name('api.tables.find');
    Route::post('/tables/rates', [App\Http\Api\TablesController::class, 'rates'])->name('api.tables.rates');
    Route::post('/tables/rate', [App\Http\Api\TablesController::class, 'rate'])->name('api.tables.rate');

    // Favorites
    Route::get('/user/favorites', [App\Http\Api\FavoritesController::class, 'list'])->name('api.user.favorites.list');
    Route::get('/user/favorite/add/{place_id}', [App\Http\Api\FavoritesController::class, 'add'])->name('api.user.favorites.add');
    Route::get('/user/favorite/remove/{favorite_id}', [App\Http\Api\FavoritesController::class, 'remove'])->name('api.user.favorites.remove');

    // Policies
    Route::get('/place_policies/{place_id}', [App\Http\Api\PoliciesController::class, 'list'])->name('api.place_policies.list');
    Route::get('/place_policy/{place_id}/{policy_type}', [App\Http\Api\PoliciesController::class, 'load_by_type'])->name('api.place_policies.load_by_type');

    // Ratings
    Route::get('/user/ratings', [App\Http\Api\RatingsController::class, 'list'])->name('api.user.ratings.list');
    Route::post('/user/rating/add', [App\Http\Api\RatingsController::class, 'add'])->name('api.user.ratings.add');
    Route::get('/user/rating/remove/{rating_id}', [App\Http\Api\RatingsController::class, 'remove'])->name('api.user.ratings.remove');

    // Bookings
    Route::get('/user/bookings', [App\Http\Api\BookingsController::class, 'list'])->name('api.user.bookings.list');
    Route::post('/user/booking/book', [App\Http\Api\BookingsController::class, 'book'])->name('api.user.bookings.book');
    Route::post('/user/booking/cancel', [App\Http\Api\BookingsController::class, 'cancel'])->name('api.user.bookings.cancel');

    // Payments
    Route::post('/payments/stripe', [App\Http\Api\PaymentsController::class, 'stripe'])->name('api.payments.stripe');
    Route::post('/payments/add', [App\Http\Api\PaymentsController::class, 'add'])->name('api.payments.add');
    Route::get('/payments/remove/{id}', [App\Http\Api\PaymentsController::class, 'remove'])->name('api.payments.remove');
    Route::get('/payments/{booking_id}', [App\Http\Api\PaymentsController::class, 'list'])->name('api.payments.list');

    // Users
    Route::get('/user/find/{id}', [App\Http\Api\UsersController::class, 'find'])->name('api.users.find');

    // Profile
    Route::get('/user/profile/load', [App\Http\Api\UsersController::class, 'load_profile'])->name('api.user.profile.load');
    Route::post('/user/profile/update', [App\Http\Api\UsersController::class, 'update'])->name('api.user.profile.update');
    Route::post('/user/profile/upload_avatar', [App\Http\Api\UsersController::class, 'upload_avatar'])->name('api.user.profile.upload_avatar');
    Route::post('/user/profile/save_phone_number', [App\Http\Api\UsersController::class, 'save_phone_number'])->name('api.user.profile.save_phone_number');

    // Government ID
    Route::post('/user/profile/upload_government_id', [App\Http\Api\UsersController::class, 'upload_government_id'])->name('api.user.profile.upload_government_id');
    Route::post('/user/profile/save_government_id', [App\Http\Api\UsersController::class, 'save_government_id'])->name('api.user.profile.save_government_id');

    // Twilio/ChatController
    Route::post('/chat/token', [App\Http\Api\Twilio\ChatController::class, 'token'])->name('api.chat.token');

    // Staff
    Route::get('/staff/sign_out', [App\Http\Api\Staff\AuthController::class, 'sign_out'])->name('api.staff.sign_out');
    Route::get('/staff/logged_user', [App\Http\Api\Staff\AuthController::class, 'logged_user'])->name('api.staff.logged_user');
    Route::get('/staff/valid_user', [App\Http\Api\Staff\AuthController::class, 'valid_user'])->name('api.staff.valid_user');

    // Notifications
    Route::post('/notifications/send_email', [App\Http\Api\NotificationsController::class, 'send_email'])->name('api.notifications.send_email');
    Route::post('/notifications/send_sms', [App\Http\Api\NotificationsController::class, 'send_sms'])->name('api.notifications.send_sms');
    Route::post('/notifications/send_validation', [App\Http\Api\NotificationsController::class, 'send_validation'])->name('api.notifications.send_validation');

    // Table Spends
    Route::post('/table/spend/add', [App\Http\Api\TableSpendsController::class, 'add'])->name('api.table.spends.add');
    Route::get('/table/spend/remove/{id}', [App\Http\Api\TableSpendsController::class, 'remove'])->name('api.table.spends.remove');
    Route::post('/table/spends', [App\Http\Api\TableSpendsController::class, 'list'])->name('api.table.spends.list');

    // User Settings
    Route::get('/user/settings', [App\Http\Api\UserSettingsController::class, 'list'])->name('api.user.setting.list');
    Route::post('/user/setting/save', [App\Http\Api\UserSettingsController::class, 'save'])->name('api.user.setting.save');

    // Booking Guests
    Route::get('/booking/guests/{booking_id}', [App\Http\Api\BookingGuestsController::class, 'list'])->name('api.booking.guests.list');
    Route::post('/booking/guest/save', [App\Http\Api\BookingGuestsController::class, 'save'])->name('api.booking.guests.save');
    Route::get('/booking/guest/remove/{id}', [App\Http\Api\BookingGuestsController::class, 'remove'])->name('api.booking.guests.remove');

    // Staff Booking
    Route::post('/staff/bookings/inbox', [App\Http\Api\Staff\BookingsController::class, 'inbox'])->name('api.staff.booking.inbox');
    Route::post('/staff/bookings/assigned', [App\Http\Api\Staff\BookingsController::class, 'assigned'])->name('api.staff.booking.assigned');

    Route::post('/staff/booking/assign', [App\Http\Api\Staff\BookingsController::class, 'assign'])->name('api.staff.booking.assign');
    Route::post('/staff/booking/close', [App\Http\Api\Staff\BookingsController::class, 'close'])->name('api.staff.booking.close');
    Route::post('/staff/booking/cancel', [App\Http\Api\Staff\BookingsController::class, 'cancel'])->name('api.staff.booking.cancel');

    // Booking Chats
    Route::get('/booking/chats', [App\Http\Api\BookingChatsController::class, 'list'])->name('api.booking.chat.list');
    Route::post('/booking/chat/save', [App\Http\Api\BookingChatsController::class, 'save'])->name('api.booking.chat.save');

    // Staff Table Spends
    Route::post('/staff/table-spends', [App\Http\Api\Staff\TableSpendsController::class, 'list'])->name('api.staff.table_spends.list');

    // Broadcast & Events
    Route::post('/broadcast/payment/request', [App\Http\Api\BroadcastController::class, 'payment_request'])->name('api.broadcast.payment.request');
    Route::post('/broadcast/message/sent', [App\Http\Api\BroadcastController::class, 'message_sent'])->name('api.broadcast.message.sent');

    // Geocode
    // Route::get('/geocode/resolve', [App\Http\Api\GeocodeController::class, 'resolve'])->name('api.geocode.resolve');
});
