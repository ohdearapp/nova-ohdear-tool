<?php

namespace OhDear\OhDearTool;

use OhDear\OhDearTool\Exceptions\ConfigNotCorrect;
use OhDear\PhpSdk\OhDear;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use OhDear\OhDearTool\Http\Middleware\Authorize;

class OhDearToolServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/nova-ohdear-tool.php' => config_path('nova-ohdear-tool.php'),
        ], 'config');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'OhDearTool');

        $this->app->booted(function () {
            $this->routes();
        });

        $this->app->singleton(OhDear::class, function () {
            $token = config('nova-ohdear-tool.api_token');
            if (! $token) {
                throw ConfigNotCorrect::apiTokenMissing();
            }

            return new OhDear($token);
        });
    }

    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
            ->prefix('/nova-vendor/ohdearapp/oh-dear-tool')
            ->group(
                __DIR__.'/../routes/api.php'
            );
    }
}
