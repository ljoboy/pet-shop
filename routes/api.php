<?php

use App\Http\Controllers\Api\V1\Auth\Admin\AdminAuthController;
use App\Http\Controllers\Api\V1\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\V1\Auth\PasswordResetController;
use App\Http\Controllers\Api\V1\Auth\User\UserAuthController;
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
            Route::post('create', 'create');
        });
        Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
        Route::post('reset-password-token', [PasswordResetController::class, 'resetPassword']);
    });
    Route::controller(AdminAuthController::class)->prefix('admin')->group(function () {
        Route::post('login', 'login');
        Route::get('logout', 'logout');
        Route::post('create', 'create');
    });

    Route::middleware(['auth:api'])->group(function () {
        // Admin endpoint
        Route::prefix('admin')->group(function () {
            Route::get('/ok', function () {
                return auth()->payload()->get('user_uuid');
            });
        });
        // User endpoint
        Route::prefix('user')->group(function () {

        });
    });
});
