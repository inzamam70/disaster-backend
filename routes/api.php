<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AidController;
use App\Http\Controllers\Auth\AuthenticatedApiController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LandingcardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NavController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleNavItemController;
use App\Http\Controllers\SliderController;

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

Route::prefix('massages')->group(function () {
    Route::get('/', [MessageController::class, 'index']);
    Route::post('/', [MessageController::class, 'sendMassage']);
});

Route::post('/register', [AuthenticatedApiController::class, 'register'])->middleware('guest:api');
Route::post('/login', [AuthenticatedApiController::class, 'login'])->middleware('guest:api');
Route::post('/logout', [AuthenticatedApiController::class, 'logout'])->middleware('auth:api');

Route::post('/refresh-token', [AuthenticatedApiController::class, 'refreshToken'])->middleware('auth:api')->name('refresh-token');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/verify/login', [AuthenticatedApiController::class, 'verifyLogin']);
// Route::middleware('auth:api')->post('/refresh-token', 'AuthenticatedApiController@refreshToken');

