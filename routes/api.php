<?php

use App\Http\Controllers\Api\V1\AdminApiController;
use App\Http\Controllers\Api\V1\Auth\Admin\AdminAuthController;
use App\Http\Controllers\Api\V1\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\V1\Auth\PasswordResetController;
use App\Http\Controllers\Api\V1\Auth\User\UserAuthController;
use App\Http\Controllers\Api\V1\FileApiController;
use App\Http\Controllers\Api\V1\UserApiController;
use App\Http\Middleware\IsAdmin;
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
    // Auth endpoint
    Route::prefix('user')->group(function () {
        Route::controller(UserAuthController::class)->group(function () {
            Route::post('login', 'login');
            Route::get('logout', 'logout');
        });
        Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
        Route::post('reset-password-token', [PasswordResetController::class, 'resetPassword']);
        Route::post('create', [UserApiController::class, 'store']);
    });

    Route::prefix('admin')->group(function () {
        Route::controller(AdminAuthController::class)->group(function () {
            Route::post('login', 'login');
            Route::get('logout', 'logout');
        });
    });

    Route::middleware('auth:api')->group(function () {
        // Admin endpoints
        Route::prefix('admin')->middleware(IsAdmin::class)->group(function () {
            Route::get('user-listing', [AdminApiController::class, 'userListing']);
        });
        // User endpoints
        Route::prefix('user')->controller(UserApiController::class)->group(function () {
            Route::get('/', 'show');
            Route::delete('/', 'destroy');
            Route::put('/edit', 'update');
        });
        // File endpoints
        Route::controller(FileApiController::class)->prefix('file')->group(function () {
            Route::get('/{file}', 'show');
            Route::post('/upload', 'store');
        });
    });
});
