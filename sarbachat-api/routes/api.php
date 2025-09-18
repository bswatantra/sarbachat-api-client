<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Social\SocialAuthController;

Route::prefix('social')->group(function () {
    Route::get('{provider}', [SocialAuthController::class, 'redirect']);
    Route::get('{provider}/callback', [SocialAuthController::class, 'authenticateProvideCallback']);
});
