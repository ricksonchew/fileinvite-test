<?php

namespace App\Providers;

use App\Http\Services\Bookings\Services\BookingsService;
use App\Http\Services\Bookings\Services\BookingsServiceInterface;
use App\Http\Services\Login\Services\LoginService;
use App\Http\Services\Login\Services\LoginServiceInterface;
use App\Http\Services\Logout\Services\LogoutService;
use App\Http\Services\Logout\Services\LogoutServiceInterface;
use App\Http\Services\Registration\Services\RegistrationService;
use App\Http\Services\Registration\Services\RegistrationServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(LoginServiceInterface::class, function()
        {
            return new LoginService();
        });

        $this->app->singleton(RegistrationServiceInterface::class, function()
        {
            return new RegistrationService();
        });

        $this->app->singleton(LogoutServiceInterface::class, function()
        {
            return new LogoutService();
        });

        $this->app->singleton(BookingsServiceInterface::class, function()
        {
            return new BookingsService();
        });
    }
}
