<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Http\Responses\LogoutResponse as DefaultLogoutResponse;


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
        $this->app->bind(LogoutResponse::class, DefaultLogoutResponse::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
