<?php

namespace App\Providers;

use Validator;
use Blade;

use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {
              Validator::extend('cmail', function($attribute, $value, $parameters) {
            $part2='';

           @list($part1, $part2) = explode('@', $value);

            $mail=array('gmail.com','outlook.com','yahoo.com','hotmail.com','googlemail.com','outlook.com');

          if(in_array($part2, $mail))
            {
                return false;

            }

            return true;
        });

        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });
    }
}
