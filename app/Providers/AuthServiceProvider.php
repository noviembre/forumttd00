<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Thread' => 'App\Policies\ThreadPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /*
        |--------------------------------------------------------------------------
        | If you uncomment that code you'll be able to delete any thread.
        |--------------------------------------------------------------------------
        |
        */

//        Gate::before(function ($user)
//        {
//            if ( $user->name === 'Manu' ){
//                return true;
//            }
//        });
    }
}
