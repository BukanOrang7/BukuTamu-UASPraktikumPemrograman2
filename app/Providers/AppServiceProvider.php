<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $view->with('allEvents', Event::orderBy('tanggal_acara', 'desc')->get());
        });
    }

}
