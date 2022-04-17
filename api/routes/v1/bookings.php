<?php

use App\Http\Services\Bookings\Controllers\BookingsController;

Route::group(['prefix' => 'bookings'], function() {
    Route::get('/', [BookingsController::class, 'list'])->name('bookings.list');
    Route::post('/', [BookingsController::class, 'create'])->name('bookings.create');
});

