<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapUsersRoutes();

        $this->mapCrmRoutes();

        $this->mapApiRoutes();
    }

    /**
     * Define the "users" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapUsersRoutes()
    {
        Route::middleware('users')
            ->group(base_path('routes/users.php'));
    }

    /**
     * Define the "employers" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapCrmRoutes()
    {
        Route::middleware('crm')
            ->namespace('App\Http\Controllers\Crm')
            ->name('crm.')
            ->prefix('crm')
            ->group(base_path('routes/crm.php'));
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->group(base_path('routes/api.php'));
    }
}
