<?php

namespace App\Providers;

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
        $this->app->bind(LoanDetailsRepository::class, function ($app) {
            return new LoanDetailsRepository();
        });
        $this->app->bind(EmiDetailsRepository::class, function ($app) {
            return new EmiDetailsRepository();
        });
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
