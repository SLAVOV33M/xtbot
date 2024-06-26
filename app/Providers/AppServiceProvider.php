<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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
        Validator::extend(
            'iunique',
            function ($attribute, $value, $parameters, $validator) {
                $query = DB::table($parameters[0]);
                $column = $query->getGrammar()->wrap($parameters[1]);
                return ! $query->whereRaw("lower({$column}) = lower(?)", [$value])->count();
            }
        );
    }
}
