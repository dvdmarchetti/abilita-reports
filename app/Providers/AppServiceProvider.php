<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
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
                $parameter_value = strtolower(data_get($validator->attributes(), $parameter));
                if ($parameter_value !== strtolower($value) && !in_array($parameter_value, static::$notAvailableWords)) {
                    return false;
                }
            }

            return true;
        });

        Validator::replacer('same_insensitive', function ($message, $attribute, $rule, $parameters) {
            // dd($message, $attribute, $rule, $parameters);
            return str_replace(':other', $parameters[0], $message);
        });

        $this->ensureDatabaseIsMigrated();
    }

    public function ensureDatabaseIsMigrated()
    {
        if (! (Schema::hasTable('children') && Schema::hasTable('child_service') && Schema::hasTable('services') && Schema::hasTable('families') && Schema::hasTable('log_messages'))) {
            Artisan::call('migrate:fresh --force -q');
        }
    }
}
