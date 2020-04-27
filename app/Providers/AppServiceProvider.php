<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    private static $notAvailableWords = [
        'na',
        'n.a',
        'n.a.',
    ];

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
                if (strtolower($validator->attributes()[$parameter]) !== strtolower($value) && !in_array(strtolower($validator->attributes()[$parameter]), static::$notAvailableWords)) {
                    return false;
                }
            }

            return true;
        });

        Validator::replacer('same_insensitive', function ($message, $attribute, $rule, $parameters) {
            // dd($message, $attribute, $rule, $parameters);
            return str_replace(':other', $parameters[0], $message);
        });
    }
}
