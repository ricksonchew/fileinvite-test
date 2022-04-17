<?php

use App\Http\Services\Logout\Controllers\LogoutController;

Route::post('logout', [LogoutController::class, 'logout'])->name('logout');
