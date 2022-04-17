<?php

use App\Http\Services\Registration\Controllers\RegistrationController;

Route::post('registration', [RegistrationController::class, 'registration'])->name('registration');
