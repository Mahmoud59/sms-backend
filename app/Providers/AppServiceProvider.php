<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191); //NEW: Increase StringLength

        Validator::extend('white_space', function ($attribute, $value, $parameters, $validator) {
            //  return true;
            return preg_match('/^[\p{Arabic}\pL\s]+$/u', $value);
        });

        Validator::extend('name_with_number', function ($attribute, $value, $parameters, $validator) {
            //   return true;
            return preg_match('/^[\p{Arabic}\pL-_\s\p{N}]+$/u', $value);
        });

        Validator::extend('password_validation', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/u', $value);
        }); /// Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character .

    }
}
