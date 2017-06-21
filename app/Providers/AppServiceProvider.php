<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
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
        Validator::extend('fieldCantAffectItself', function ($attribute, $value, $parameters, $validator) {
            $attribute = explode('.', $attribute);
            
            return request('fields')[$attribute[1]]['name'] !== $value;
        });

        Validator::extend('fieldValidAffectOption', function ($attribute, $value, $parameters, $validator) {
            $field_names = collect(request('fields'))->pluck('name');
            $field_names[] = 'total';
            
            return in_array($value, $field_names->toArray());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
