<?php

namespace App\Providers;

use App\Extensions\ResponseDebugFactory;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\View\Factory as ViewFactoryContract;
use Illuminate\Contracts\Routing\ResponseFactory as ResponseFactoryContract;

class DeveloperServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->singleton(\Faker\Generator::class, function () {
                return \Faker\Factory::create('ru_RU');
            });

            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        if (env('APP_DEBUG')) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
            AliasLoader::getInstance()->alias('Debugbar', \Barryvdh\Debugbar\Facade::class);

            $this->app->singleton(ResponseFactoryContract::class, function ($app) {
                return new ResponseDebugFactory($app[ViewFactoryContract::class], $app['redirect']);
            });
        }
    }
}
