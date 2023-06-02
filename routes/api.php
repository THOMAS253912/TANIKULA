<?php

use App\Http\Controllers\Api\Customer\AddressApiController;
use App\Http\Controllers\Api\Customer\CartApiController;
use App\Http\Controllers\Api\Customer\ChatApiController;
use App\Http\Controllers\Api\Customer\CheckoutApiController;
use App\Http\Controllers\Api\Customer\CustomerApiController;
use App\Http\Controllers\Api\Customer\ForgetPasswordApiController;
use App\Http\Controllers\Api\Customer\HeroesApiController;
use App\Http\Controllers\Api\Customer\LoginCustomerApiController;
use App\Http\Controllers\Api\Customer\ParticipantChatApiController;
use App\Http\Controllers\Api\Customer\ProductCustomerApiController;
use App\Http\Controllers\Api\Customer\RegisterCustomerApiController;
use App\Http\Controllers\Api\Customer\ReviewApiController;
use App\Http\Controllers\Api\Customer\ReviewPublicApiController;
use App\Http\Controllers\Api\Customer\RoomChatApiController;
use App\Http\Controllers\Api\Customer\TransactionListApiController;
use App\Http\Controllers\Api\Customer\WishlistApiController;
use App\Http\Controllers\Api\Gapoktan\ActivityApiController;
use App\Http\Controllers\Api\Gapoktan\ActivityCategoryApiController;
use App\Http\Controllers\Api\Gapoktan\EducationApiController;
use App\Http\Controllers\Api\Gapoktan\EducationCategoryApiController;
use App\Http\Controllers\Api\Gapoktan\GapoktanApiController;
use App\Http\Controllers\Api\Gapoktan\LoginGapoktanApiController;
use App\Http\Controllers\Api\Gapoktan\PoktanApiController;
use App\Http\Controllers\Api\Petani\AkunPetaniApiController;
use App\Http\Controllers\Api\Petani\FarmerApiController;
use App\Http\Controllers\Api\Petani\LoginPetaniApiController;
use App\Http\Controllers\Api\Petani\PlantApiController;
use App\Http\Controllers\Api\PhotoProductApiControlller;
use App\Http\Controllers\Api\Poktan\AkunPoktanApiController;
use App\Http\Controllers\Api\Poktan\LoginPoktanApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\ProductCategoryApiController;
use App\Http\Controllers\Api\PushNotificationController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Support\Facades\Route;
use Midtrans\Transaction;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->group(function () {
    // All
    Route::resource('product', ProductApiController::class);
    // Route::get('product/search/{name}', [ProductApiController::class, 'search']);
    Route::resource('product-photo', PhotoProductApiControlller::class);
    Route::post('product-photo/delete-where-id-product', [PhotoProductApiControlller::class, 'deleteWhereProductId']);

    // Chat
    Route::resource('chat', ChatApiController::class);
    Route::resource('room-chat', RoomChatApiController::class);
    Route::resource('participant-chat', ParticipantChatApiController::class);

    // ------ Customer -----------
    Route::resource('cart', CartApiController::class);
    Route::put('cart/qty/{id}', [CartApiController::class, 'updateQty']);
    Route::resource('customer', CustomerApiController::class);
    Route::post('customer/update/image', [CustomerApiController::class, 'updatePhoto']);
    Route::get('cart/user_id/{user_id}', [CartApiController::class, 'indexByid']);
    Route::resource('wishlist', WishlistApiController::class);
    Route::get('wishlist/user_id/{user_id}', [WishlistApiController::class, 'indexByid']);
    Route::resource('address', AddressApiController::class);
    Route::get('address/user_id/{user_id}', [AddressApiController::class, 'indexByid']);
    Route::put('address/main_address/{user_id}', [AddressApiController::class, 'updateMainAddress']);
    Route::post('/cart/shipment/place-order', [CheckoutApiController::class, 'placeOrder']);
    Route::get('transaction_list/{user_id}', [TransactionListApiController::class, 'index']);
    Route::post('/transaction_list/detail_transaction/{id}', [TransactionListApiController::class, 'detailPesanan']);
    Route::resource('review', ReviewApiController::class);
    Route::get('notification_list/{user_id}', [PushNotificationController::class, 'indexByid']);
    Route::get('notification_list/delete-all/{user_id}', [PushNotificationController::class, 'deleteall']);

    // ------ Gapoktan -----------
    // Activity
    Route::resource('activity', ActivityApiController::class);
    Route::get('activity/search/{title}', [ActivityApiController::class, 'search']);
    Route::resource('activity-category', ActivityCategoryApiController::class);
    //Education
    Route::resource('education-category', EducationCategoryApiController::class);
    Route::resource('education', EducationApiController::class);
    Route::get('education/search/{title}', [EducationApiController::class, 'search']);
    Route::post('education/update/file', [EducationApiController::class, 'updateWFile']);
    // Poktan
    Route::resource('poktan', PoktanApiController::class);
    Route::resource('akun-poktan', AkunPoktanApiController::class);
    Route::post('akun-poktan/update/image', [AkunPoktanApiController::class, 'updatePhoto']);
    //Gapoktan
    Route::resource('gapoktan', GapoktanApiController::class);
    Route::post('gapoktan/update/image', [GapoktanApiController::class, 'updatePhoto']);

    //Petani
    Route::resource('plant', PlantApiController::class);
    Route::get('plant/farmer/{id}', [PlantApiController::class, 'indexByIdUser']);
    Route::put('plant/harvest-date/{id}', [PlantApiController::class, 'addHarvestDate']);
    Route::put('plant/status/{id}', [PlantApiController::class, 'updateStatus']);
    Route::resource('farmer', FarmerApiController::class);
    Route::resource('akun-petani', AkunPetaniApiController::class);
    Route::post('akun-petani/update/image', [AkunPetaniApiController::class, 'updatePhoto']);
    // tandur
    Route::get('plant/field/id/{id}', [PlantApiController::class, 'field']);
    Route::get('plant/farmer/id/{id}', [PlantApiController::class, 'plant']);
    Route::post('plant/plant/post', [PlantApiController::class, 'storePlant']);
    // panen
    Route::get('plant/harvest/plant/{id}', [PlantApiController::class, 'plantDataForHarvest']);
    Route::get('plant/harvest/{id}', [PlantApiController::class, 'harvest']);
    Route::post('plant/harvest/post', [PlantApiController::class, 'doHarvest']);
    Route::post('plant/harvest/update', [PlantApiController::class, 'updatePanen']);

    // user
    Route::resource('user', UserApiController::class);
});



// ------ Customer -----------
Route::get('product-customer', [ProductCustomerApiController::class, 'index']);
Route::get('product-customer/detail/{slug}', [ProductCustomerApiController::class, 'detail']);
Route::get('product-customer/search/{name}', [ProductCustomerApiController::class, 'search']);
Route::get('product-customer/category/{id}', [ProductCustomerApiController::class, 'category']);
Route::get('product-customer/toko/{id}', [ProductCustomerApiController::class, 'tokoById']);
Route::get('hero', [HeroesApiController::class, 'index']);

// Route::post('view_category/{slug}', [ProductCustomerApiController::class, 'viewCategory']);
Route::post('login-customer', [LoginCustomerApiController::class, 'login']);
Route::post('forget-password', [ForgetPasswordApiController::class, 'forgotPasswordEmail']);
Route::resource('review_public', ReviewPublicApiController::class);
Route::get('star_rated/{id}', [ReviewPublicApiController::class, 'starRated']);
Route::post('register-customer', [RegisterCustomerApiController::class, 'register']);
Route::resource('product-photo-customer', PhotoProductApiControlller::class);
Route::resource('product-category', ProductCategoryApiController::class);

//tes api
// Route::post('notif', [ProductCustomerApiController::class, 'sendnofit']);

// // Cart
// Route::resource('cart', CartApiController::class);
// Route::get('cart/user_id/{user_id}', [CartApiController::class, 'indexByid']);
// Wishlist


// ------ Gapoktan -----------
Route::post('login-gapoktan', [LoginGapoktanApiController::class, 'login']);

// ------ Gapoktan -----------
Route::post('login-poktan', [LoginPoktanApiController::class, 'login']);

Route::post('/save-token', [App\Http\Controllers\Pembeli\ChatController::class, 'tokenFcm']);

// ------ Petani -----------
Route::post('login-petani', [LoginPetaniApiController::class, 'login']);

// // Notification Controllers
// Route::post('send', [PushNotificationController::class, 'bulksend'])->name('bulksend');
// Route::get('all-notifications', [PushNotificationController::class, 'index']);
// Route::get('get-notification-form', [PushNotificationController::class, 'create']);

// Tes notifikasi
Route::post('send-notification', [PushNotificationController::class, 'tesApi']);
