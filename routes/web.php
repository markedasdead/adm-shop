<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', [AdminController::class, 'index']);
Route::post('/admin/login', [AdminController::class, 'authenticate']);

Route::middleware(\App\Http\Middleware\CheckAdmin::class)->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/products', [ProductController::class, 'listPage']);
        Route::get('/products/{product}', [ProductController::class, 'showDetails']);
        Route::get('/products/{product}/edit', [ProductController::class, 'showEditForm']);
        Route::post('/products', [ProductController::class, 'store']);
        Route::patch('/products/{product}', [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);

        Route::get('/categories/create', function() {
            return view('category_create');
        });
        Route::get('/categories/{category}', [CategoryController::class, 'showDetails']);
        Route::get('/categories/{category}/products/create', [CategoryController::class, 'showProductCreateForm']);
        Route::get('/categories/{category}/edit', [CategoryController::class, 'showEditForm']);
        Route::any('/categories', [CategoryController::class, 'index']);
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::patch('/categories/{category}', [CategoryController::class, 'update']);
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

        Route::get('/orders', [OrderController::class, 'listPage']);
    });
});

Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');