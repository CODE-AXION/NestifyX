<?php

namespace CodeAxion\NestifyX;

use Illuminate\Support\ServiceProvider;

class NestifyXServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */

    public function boot()
    {
 
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'nestifyx');
     

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/nestifyx.php' => config_path('nestifyx.php'),
            ], 'config');

               $this->publishes([
                __DIR__ . '/../database/migrations/update_categories_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_update_categories_table.php'),
            ], 'migrations');


            $this->publishes([
                __DIR__.'/../resources/views/components/' => resource_path('views/components/nestifyx'),
            ], 'components');

          
        }
        $this->registerRoutes();
    }


    protected function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/nestifyx.php', 'nestifyx');

        $this->app->singleton('nestifyx', function () {
            return new NestifyX;
        });
    }
}
