<?php

use Illuminate\Http\Request;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => 'v1'], function() {
    Route::middleware(['api.json'])->group(function () {
        require __DIR__ . '/v1/login.php';
        require __DIR__ . '/v1/registration.php';
    });

    Route::middleware(['auth:api', 'gated'])->group(function () {
        require __DIR__ . '/v1/logout.php';
        require __DIR__ . '/v1/bookings.php';
    });
});
