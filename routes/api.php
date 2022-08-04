<?php

use App\Http\Controllers\Api\V1\AdminApiController;
use App\Http\Controllers\Api\V1\Auth\AdminAuthController;
use App\Http\Controllers\Api\V1\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\V1\Auth\PasswordResetController;
use App\Http\Controllers\Api\V1\Auth\UserAuthController;
use App\Http\Controllers\Api\V1\BrandApiController;
use App\Http\Controllers\Api\V1\CategoryApiController;
use App\Http\Controllers\Api\V1\FileApiController;
use App\Http\Controllers\Api\V1\FileController;
use App\Http\Controllers\Api\V1\ProductApiController;
use App\Http\Controllers\Api\V1\UserApiController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUser;
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

Route::prefix('v1')->group(function () {
    // Admin endpoints
    Route::prefix('admin')->group(function () {
        Route::controller(AdminAuthController::class)->group(function () {
            Route::post('/login', 'login');
            Route::get('/logout', 'logout');
        });
        Route::controller(AdminApiController::class)->group(function () {
            Route::post('/create', 'store');
            Route::get('/user-listing', 'userListing');
            Route::put('/user-edit/{user}', 'update');
            Route::delete('/user-delete/{user}', 'destroy');
        });
    });
    // User endpoints
    Route::prefix('user')->group(function () {
        Route::controller(UserAuthController::class)->group(function () {
            Route::post('/login', 'login');
            Route::get('/logout', 'logout');
        });
        Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
        Route::post('reset-password-token', [PasswordResetController::class, 'resetPassword']);
        Route::controller(UserApiController::class)->group(function () {
            Route::get('/', 'show');
            Route::delete('/', 'destroy');
            Route::put('/edit', 'update');
            Route::post('/create', 'store');
        });
    });
    // Brand endpoints
    Route::get('/brands', [BrandApiController::class, 'index']);
    Route::post('/brand/create', [BrandApiController::class, 'store']);
    Route::apiResource('brand', BrandApiController::class)->except(['index', 'store']);
    // Categorie endpoints
    Route::get('/categories', [CategoryApiController::class, 'index']);
    Route::post('/categorie/create', [CategoryApiController::class, 'store']);
    Route::apiResource('categorie', CategoryApiController::class)->except(['index', 'store']);
    // Product endpoints
    Route::get('/products', [ProductApiController::class, 'index']);
    Route::post('/product/create', [ProductApiController::class, 'store']);
    Route::apiResource('product', ProductApiController::class)->except(['index', 'store']);
    // File endpoints
    Route::controller(FileApiController::class)->prefix('file')->group(function () {
        Route::post('upload', 'store');
        Route::get('/{file}', 'show');
    });
});
