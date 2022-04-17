<?php

use App\Http\Services\Login\Controllers\LoginController;

Route::post('login', [LoginController::class, 'login'])->name('login');
