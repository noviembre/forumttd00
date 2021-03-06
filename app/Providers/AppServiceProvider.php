<?php

namespace App\Providers;

use App\Channel;
use Illuminate\Filesystem\Cache;
use Illuminate\Support\Facades\Validator;
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
        if ( $this->app->isLocal() ) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
        |--------------------------------------------------------------------------
        | Sharing Threads List view with * project
        |--------------------------------------------------------------------------
        |se regreso a este codigo pq, al momento de migrar ocasionaba un error.
        */
        \View::composer('*', function ($view) {
            $view->with('channels', Channel::all());

        });

        Validator::extend('spamfree', 'App\Rules\SpamFree@passes');
    }
}
