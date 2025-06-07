<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

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
        // Enable query caching in production
        if (app()->environment('production')) {
            DB::enableQueryLog();
        }
        
        // Share common data across views to reduce database queries
        View::composer(['layouts.nav'], function ($view) {
            if (auth()->check()) {
                $view->with('currentUser', auth()->user());
            }
        });
    }
}
