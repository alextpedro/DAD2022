<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\UserController;

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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

// Routes that require login. 
Route::middleware('auth:api')->group(function () {
    //All User routes
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('users/me', [UserController::class, 'show_me']);

    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{user}', [UserController::class, 'show']);
        // ->middleware('can:view,user');
    Route::put('users/{user}', [UserController::class, 'update']);
        // ->middleware('can:update,user');
    Route::patch('users/{user}/password', [UserController::class, 'update_password']);
        // ->middleware('can:updatePassword,user');
    Route::delete('users/{id}', [UserController::class, 'destroy']);
        // ->middleware('can:destroy,user');
    

    // Route::get('users/{user}/orders', [OrderController::class, 'getOrdersOfUser']);
    Route::get('orders/{id}', [OrderController::class, 'getOrdersOfUser']);
    Route::post('orders', [OrderController::class, 'store']);

    Route::post('products', [ProductController::class, 'store']);
    Route::put('products/{id}', [ProductController::class, 'update']);
    Route::delete('products/{id}', [ProductController::class, 'destroy']);

});

Route::get('products', [ProductController::class, 'index']);

Route::get('orders', [OrderController::class, 'getOrdersReady']);

