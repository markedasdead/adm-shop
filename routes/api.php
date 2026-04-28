<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/registration', [\App\Http\Controllers\UserController::class, "register"]);
Route::post('/auth', [\App\Http\Controllers\UserController::class, "authenticate"]);

Route::get('/categories', [\App\Http\Controllers\CategoryController::class, "index"]);

Route::get('/categories/{category}/products', [\App\Http\Controllers\ProductController::class, "listByCategoryApi"]);
Route::get('/products/{product}', [\App\Http\Controllers\ProductController::class, "showApi"]);

Route::post('/payment-webhook', [\App\Http\Controllers\OrderController::class, "handlePaymentWebhook"]);

Route::middleware(\App\Http\Middleware\CheckToken::class)->group(function () {
    Route::post('/products/{product}/buy', [\App\Http\Controllers\OrderController::class, "store"]);
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, "listApi"]);
});
