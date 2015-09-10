<?php

namespace ineluctable\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Guard;
use ineluctable\Auth\IneluctableGuard;
use Illuminate\Auth\EloquentUserProvider;

class IneluctableAuth extends ServiceProvider
{


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // TODO: Implement register() method.
    }

    public function boot()
    {

        \Auth::extend('ineluctable_driver', function() {
            $model = \Config::get('auth.model');
            $provider = new EloquentUserProvider(\App::make('hash'), $model);
            return new IneluctableGuard($provider, \App::make('session.store'));
        });
    }
}
