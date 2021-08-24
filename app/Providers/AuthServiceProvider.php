<?php

namespace App\Providers;

use App\Models\PersonalAccessToken;
use App\Models\Role;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Models\Role' => 'App\Policies\RolePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function($user, $ability) {
            if ($user->type == 'super-admin') {
                return true;
            }
            if ($user->type == 'user') {
                return false;
            }
        });

        /*foreach (config('abilities') as $key => $value) {
            Gate::define($key, function($user) use ($key, $value) {
                $user->hasAbility($key);
            });
        }*/

        \Laravel\Sanctum\Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

    }
}
