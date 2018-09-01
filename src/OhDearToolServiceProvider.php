<?php

namespace OhDear\OhDearTool;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use OhDear\OhDearTool\Controllers\TailController;
use OhDear\OhDearTool\Http\Middleware\Authorize;

class OhDearToolServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'OhDearTool');

        $this->app->booted(function () {
            $this->routes();
        });
    }

    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
            ->prefix('/nova-vendor/ohdearapp/tail-tool')
            ->group(
                __DIR__ . '/../routes/api.php'
            );
    }
}
