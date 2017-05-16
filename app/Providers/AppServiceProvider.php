<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('isin', function($attribute, $value, $parameters)
        {
            if (!is_array($parameters) || empty($parameters['0'])) {
                return true;
            }
            $table = $parameters['0'];
            $name = empty($parameters['1']) ? $attribute : $parameters['1'];
            $get = DB::table($table)
                        ->where($name, $value)
                        ->first();
            if ($get) {
                return true;
            }
            return false;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
