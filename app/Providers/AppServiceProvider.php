<?php

namespace App\Providers;

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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('same_insensitive', function ($attribute, $value, $parameters, $validator) {
            foreach ($parameters as $parameter) {
                if (strtolower($validator->attributes()[$parameter]) !== strtolower($value)) {
                    return false;
                }
            }

            return true;
        });
    }
}
