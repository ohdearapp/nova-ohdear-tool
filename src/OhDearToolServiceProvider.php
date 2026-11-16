<?php

namespace OhDear\OhDearTool;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Http\Middleware\Authorize as AuthorizeNova;
use Laravel\Nova\Nova;
use OhDear\OhDearTool\Exceptions\ConfigNotCorrect;
use OhDear\OhDearTool\Http\Middleware\Authorize;
use OhDear\PhpSdk\Dto\Monitor;
use OhDear\PhpSdk\Exceptions\OhDearException;
use OhDear\PhpSdk\Exceptions\ValidationException;
use OhDear\PhpSdk\OhDear;
use Saloon\Exceptions\Request\FatalRequestException;

class OhDearToolServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/nova-ohdear-tool.php', 'nova-ohdear-tool');

        $this->app->singleton(OhDear::class, function () {
            $token = config('nova-ohdear-tool.api_token');

            if (! is_string($token) || $token === '') {
                throw ConfigNotCorrect::apiTokenMissing();
            }

            return new OhDear($token);
        });

        $this->app->scoped(Monitor::class, function () {
            $monitorId = filter_var(config('nova-ohdear-tool.monitor_id'), FILTER_VALIDATE_INT, [
                'options' => ['min_range' => 1],
            ]);

            if ($monitorId === false) {
                throw ConfigNotCorrect::monitorIdMissing();
            }

            return app(OhDear::class)->monitor($monitorId);
        });
    }

    public function boot(): void
    {
        $this->callAfterResolving(ExceptionHandler::class, function ($handler) {
            $handler->renderable(function (OhDearException|FatalRequestException $exception, Request $request): ?JsonResponse {
                if (! $request->is('nova-vendor/ohdearapp/oh-dear-tool/*')) {
                    return null;
                }

                if ($exception instanceof ValidationException) {
                    return response()->json([
                        'message' => 'Oh Dear could not complete this request. The check may be disabled or may not have run yet.',
                    ], 422);
                }

                return response()->json([
                    'message' => 'Could not connect to Oh Dear. Check your API token and monitor ID, then try again.',
                ], 502);
            });
        });

        $this->publishes([
            __DIR__.'/../config/nova-ohdear-tool.php' => config_path('nova-ohdear-tool.php'),
        ], 'nova-ohdear-tool-config');

        $this->app->booted(fn () => $this->routes());
    }

    protected function routes(): void
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Nova::router(['nova', 'nova.auth', AuthorizeNova::class, Authorize::class], 'oh-dear')
            ->group(__DIR__.'/../routes/inertia.php');

        Route::middleware(['nova', 'nova.auth', AuthorizeNova::class, Authorize::class])
            ->prefix('nova-vendor/ohdearapp/oh-dear-tool')
            ->group(__DIR__.'/../routes/api.php');
    }
}
