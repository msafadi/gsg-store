<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
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

        Relation::morphMap([
            'product' => Product::class,
            'profile' => Profile::class,
        ]);

        Validator::extend('filter', function($attribute, $value, $params) {
            foreach ($params as $word) {
                if (stripos($value, $word) !== false) {
                    return false;
                }
            }
            return true;

        }, 'Some words are not allowed!');

        Paginator::useBootstrap();
        //Paginator::defaultView('pagination');
    }
}
