<?php

namespace App\Providers;

use Gate;
use App\Models\Employer;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Models\Country::class      => \App\Policies\SuperUserPolicy::class,
        \App\Models\Region::class       => \App\Policies\SuperUserPolicy::class,
        \App\Models\City::class         => \App\Policies\SuperUserPolicy::class,
        \App\Models\CityDistrict::class => \App\Policies\SuperUserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['router']->matched(function (\Illuminate\Routing\Events\RouteMatched $event) {
            $route = $event->route;

            if (!array_has($route->getAction(), 'guard')) {
                return;
            }

            $routeGuard = array_get($route->getAction(), 'guard');

            $this->app['auth']->resolveUsersUsing(function ($guard = null) use ($routeGuard) {
                return $this->app['auth']->guard($routeGuard)->user();
            });

            $this->app['auth']->setDefaultDriver($routeGuard);
        });

        $this->registerPolicies();
    }
}
