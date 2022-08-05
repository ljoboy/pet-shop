<?php

use App\Http\Controllers\Api\V1\AdminApiController;
use App\Http\Controllers\Api\V1\Auth\AdminAuthController;
use App\Http\Controllers\Api\V1\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\V1\Auth\PasswordResetController;
use App\Http\Controllers\Api\V1\Auth\UserAuthController;
use App\Http\Controllers\Api\V1\BrandApiController;
use App\Http\Controllers\Api\V1\CategoryApiController;
use App\Http\Controllers\Api\V1\FileApiController;
use App\Http\Controllers\Api\V1\ProductApiController;
use App\Http\Controllers\Api\V1\UserApiController;
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
// Admin endpoints
Route::prefix('admin')->as('admin.')->group(function () {
    Route::controller(AdminAuthController::class)->group(function () {
        Route::post('/login', 'login')->name('login');
        Route::get('/logout', 'logout')->name('logout');
    });
    Route::controller(AdminApiController::class)->group(function () {
        Route::post('/create', 'store')->name('store');
        Route::get('/user-listing', 'userListing')->name('index');
        Route::put('/user-edit/{user}', 'update')->name('update');
        Route::delete('/user-delete/{user}', 'destroy')->name('destroy');
    });
});
// User endpoints
Route::prefix('user')->as('user.')->group(function () {
    Route::controller(UserAuthController::class)->group(function () {
        Route::post('/login', 'login')->name('login');
        Route::get('/logout', 'logout')->name('logout');
    });
    Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('reset-password-token', [PasswordResetController::class, 'resetPassword'])->name('reset-password');
    Route::controller(UserApiController::class)->group(function () {
        Route::get('/', 'show')->name('show');
        Route::delete('/', 'destroy')->name('destroy');
        Route::put('/edit', 'update')->name('update');
        Route::post('/create', 'store')->name('store');
    });
});
// Brand endpoints
Route::get('/brands', [BrandApiController::class, 'index'])->name('brands');
Route::post('/brand/create', [BrandApiController::class, 'store'])->name('brand.store');
Route::apiResource('brand', BrandApiController::class)->except(['index', 'store']);
// Categorie endpoints
Route::get('/categories', [CategoryApiController::class, 'index'])->name('categories');
Route::post('/categorie/create', [CategoryApiController::class, 'store'])->name('categorie.store');
Route::apiResource('categorie', CategoryApiController::class)->except(['index', 'store']);
// Product endpoints
Route::get('/products', [ProductApiController::class, 'index'])->name('products');
Route::post('/product/create', [ProductApiController::class, 'store'])->name('product.store');
Route::apiResource('product', ProductApiController::class)->except(['index', 'store']);
// File endpoints
Route::controller(FileApiController::class)->prefix('file')->as('file.')->group(function () {
    Route::post('upload', 'store')->name('store');
    Route::get('/{file}', 'show')->name('show');
});
