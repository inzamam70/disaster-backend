<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AffectedTypeController;
use App\Http\Controllers\AidController;
use App\Http\Controllers\Auth\AuthenticatedApiController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LandingcardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NavController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleNavItemController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TrainingCenterController;
use App\Http\Controllers\TransectionController;
use App\Http\Controllers\VolunteerLogController;
use App\Http\Controllers\WishlistController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    Route::post('/donations', [DonationController::class, 'create']);
    Route::get('/donations', [DonationController::class, 'index']);
});

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'create']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
    Route::post('/assign-role/{id}', [UserController::class, 'assignRole']);
    
});

Route::prefix('contacts')->group(function () {
    Route::get('/', [ContactController::class, 'index']);
    Route::post('/', [ContactController::class, 'create']);
    Route::put('/{id}', [ContactController::class, 'update']);
    Route::get('/{id}', [ContactController::class, 'show']);
    Route::delete('/{id}', [ContactController::class, 'destroy']);
});

Route::prefix('sliders')->group(function () {
    Route::get('/', [SliderController::class, 'index']);
    Route::post('/', [SliderController::class, 'create']);
    Route::put('/{id}', [SliderController::class, 'update']);
    Route::get('/{id}', [SliderController::class, 'show']);
    Route::delete('/{id}', [SliderController::class, 'destroy']);
});

Route::prefix('landingcards')->group(function () {
    Route::get('/', [LandingcardController::class, 'index']);
    Route::post('/', [LandingcardController::class, 'create']);
    Route::put('/{id}', [LandingcardController::class, 'update']);
    Route::get('/{id}', [LandingcardController::class, 'show']);
    Route::delete('/{id}', [LandingcardController::class, 'destroy']);
});

Route::prefix('navs')->group(function () {
    Route::get('/', [NavController::class, 'index']);
    Route::post('/', [NavController::class, 'create']);
    Route::put('/{id}', [NavController::class, 'update']);
    Route::get('/{id}', [NavController::class, 'show']);
    Route::delete('/{id}', [NavController::class, 'destroy']);
});

Route::prefix('roles')->group(function () {
    Route::get('/', [RoleController::class, 'index']);
    Route::post('/', [RoleController::class, 'create']);
    Route::put('/{id}', [RoleController::class, 'update']);
    Route::get('/{id}', [RoleController::class, 'show']);
    Route::delete('/{id}', [RoleController::class, 'destroy']);
});	

Route::prefix('role-navitems')->group(function () {
    Route::get('/', [RoleNavItemController::class, 'index']);
    Route::post('/', [RoleNavitemController::class, 'create']);
    Route::put('/{id}', [RoleNavitemController::class, 'update']);
    Route::get('/{id}', [RoleNavitemController::class, 'show']);
    Route::delete('/{id}', [RoleNavitemController::class, 'destroy']);
});

Route::get('user/role-nav-items/{role_id}', [RoleNavItemController::class, 'userRoleNavItems']);

Route::prefix('aids')->group(function () {
    Route::get('/', [AidController::class, 'index']);
    Route::post('/', [AidController::class, 'create']);
    Route::put('/{id}', [AidController::class, 'update']);
    Route::get('/{id}', [AidController::class, 'show']);
    Route::delete('/{id}', [AidController::class, 'destroy']);
    // Route::put('/aids/{id}/status', [AidController::class, 'updateStatus']);
    Route::post('/status/{id}', [AidController::class, 'updateStatus']);

});

Route::prefix('posts')->group(function () {
    Route::get('/', [PostController::class, 'index']);
    Route::post('/', [PostController::class, 'create']);
    Route::put('/{id}', [PostController::class, 'update']);
    Route::get('/{id}', [PostController::class, 'show']);
    Route::delete('/{id}', [PostController::class, 'delete']);
});

Route::prefix('gallerys')->group(function () {
    Route::get('/', [GalleryController::class, 'index']);
    Route::post('/', [GalleryController::class, 'create']);
    Route::put('/{id}', [GalleryController::class, 'update']);
    Route::get('/{id}', [GalleryController::class, 'show']);
    Route::delete('/{id}', [GalleryController::class, 'destroy']);
});

Route::prefix('abouts')->group(function () {
    Route::get('/', [AboutController::class, 'index']);
    Route::post('/', [AboutController::class, 'create']);
    Route::put('/{id}', [AboutController::class, 'update']);
    Route::get('/{id}', [AboutController::class, 'show']);
    Route::delete('/{id}', [AboutController::class, 'destroy']);
});

Route::prefix('affectedtypes')->group(function () {
    Route::get('/', [AffectedTypeController::class, 'index']);
    Route::post('/', [AffectedTypeController::class, 'create']);
    Route::put('/{id}', [AffectedTypeController::class, 'update']);
    Route::get('/{id}', [AffectedTypeController::class, 'show']);
    Route::delete('/{id}', [AffectedTypeController::class, 'destroy']);
});

Route::prefix('activities')->group(function () {
    Route::get('/', [ActivityController::class, 'index']);
    Route::post('/', [ActivityController::class, 'create']);
    Route::put('/{id}', [ActivityController::class, 'update']);
    Route::get('/{id}', [ActivityController::class, 'show']);
    Route::delete('/{id}', [ActivityController::class, 'destroy']);
});

Route::prefix('massages')->group(function () {
    Route::get('/', [MessageController::class, 'index']);
    Route::post('/', [MessageController::class, 'sendMassage']);
});


Route::prefix('funds')->group(function (){
    Route::get('/', [FundController::class, 'index']);
});

Route::prefix('transections')->group(function(){
    Route::get('/', [TransectionController::class, 'index']);
    Route::post('/', [TransectionController::class, 'create']);
    Route::put('/{id}', [TransectionController::class, 'update']);
    Route::get('/{id}', [TransectionController::class, 'show']);
    Route::delete('/{id}', [TransectionController::class, 'destroy']);
});

Route::prefix('centers')->group(function () {
    Route::get('/', [CenterController::class, 'index']);
    Route::post('/', [CenterController::class, 'create']);
    Route::put('/{id}', [CenterController::class, 'update']);
    Route::get('/{id}', [CenterController::class, 'show']);
    Route::delete('/{id}', [CenterController::class, 'destroy']);
});

Route::prefix('tcenters')->group(function () {
    Route::get('/', [TrainingCenterController::class, 'index']);
    Route::post('/', [TrainingCenterController::class, 'create']);
    Route::put('/{id}', [TrainingCenterController::class, 'update']);
    Route::get('/{id}', [TrainingCenterController::class, 'show']);
    Route::delete('/{id}', [TrainingCenterController::class, 'destroy']);
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'create']);
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);
});

Route::prefix('wishlists')->group(function () {
    Route::get('/{userId}', [WishlistController::class, 'index']);
    Route::post('/', [WishlistController::class, 'store']);
    Route::put('/{id}', [WishlistController::class, 'update']);
    Route::get('/{id}', [WishlistController::class, 'show']);
    Route::delete('/{id}', [WishlistController::class, 'destroy']);
});

Route::prefix('carts')->group(function () {
    Route::get('/{userId}', [CartController::class, 'index']);
    Route::post('/', [CartController::class, 'create']);
    Route::put('/{id}', [CartController::class, 'update']);
    Route::get('/{id}', [CartController::class, 'show']);
    Route::delete('/{id}', [CartController::class, 'destroy']);
});

Route::prefix('courses')->group(function () {
    Route::get('/', [CourseController::class, 'index']);
    Route::post('/', [CourseController::class, 'create']);
    Route::put('/{id}', [CourseController::class, 'update']);
    Route::get('/{id}', [CourseController::class, 'show']);
    Route::delete('/{id}', [CourseController::class, 'delete']);
});

Route::prefix('payment')->group(function () {
    Route::get('/{userId}', [PaymentController::class, 'index']);
    Route::post('/', [PaymentController::class, 'store']);
    Route::put('/{id}', [PaymentController::class, 'update']);
    Route::get('/{id}', [PaymentController::class, 'show']);
    Route::delete('/{id}', [PaymentController::class, 'destroy']);
    Route::post('/status/{id}', [PaymentController::class, 'updateStatus']);

});

Route::get('payments/alldata', [PaymentController::class, 'alldata']);

Route::post('/volunteer/clock-in', [VolunteerLogController::class, 'clockIn']);
Route::post('/volunteer/clock-out', [VolunteerLogController::class, 'clockOut']);
Route::get('/volunteer/logs/{user_id}/{center_id}', [VolunteerLogController::class, 'getLogs']);

Route::post('/register', [AuthenticatedApiController::class, 'register'])->middleware('guest:api');
Route::post('/login', [AuthenticatedApiController::class, 'login'])->middleware('guest:api');
Route::post('/logout', [AuthenticatedApiController::class, 'logout'])->middleware('auth:api');

Route::post('/refresh-token', [AuthenticatedApiController::class, 'refreshToken'])->middleware('auth:api')->name('refresh-token');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/verify/login', [AuthenticatedApiController::class, 'verifyLogin']);
// Route::middleware('auth:api')->post('/refresh-token', 'AuthenticatedApiController@refreshToken');

