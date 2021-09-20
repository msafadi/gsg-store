<?php

namespace App\Providers;

use App\Models\Config;
use App\Models\Product;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // public_path
        if ($this->app->environment('production')) {
            $this->app->bind('path.public', function($app) {
                return base_path('public_html');
            });
        }

        $this->app->singleton('paypal.client', function($app) {
            $config = config('services.paypal');
            if ($config['mode'] == 'sandbox') {
                $environment = new SandboxEnvironment($config['client_id'], $config['client_secret']);
            } else {
                $environment = new ProductionEnvironment($config['client_id'], $config['client_secret']);
            }
            $client = new PayPalHttpClient($environment);
            return $client;
        });
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();
        
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

        $settings = Cache::get('app-settings');
        if (!$settings) {
            //dd($settings);
            $settings = Config::all();
            Cache::put('app-settings', $settings);
        }

        foreach ($settings as $config) {
            config()->set($config->name, $config->value);
        }

        //config('app.currency');
    }
}
