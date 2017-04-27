<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
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

    public static function generateDropdownValues($data, $id, $text, $index){

        $values = ['' => $index];

        foreach ($data as $key => $value) {
            $values += [ $value[$id] => $value[$text] ];
        }

        return $values;

    }
}
