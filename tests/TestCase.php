<?php

namespace OhDear\OhDearTool\Tests;

use Illuminate\Foundation\Auth\User;
use Inertia\ServiceProvider as InertiaServiceProvider;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaCoreServiceProvider;
use OhDear\OhDearTool\OhDearTool;
use OhDear\OhDearTool\OhDearToolServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Saloon\Config;
use Saloon\Http\Faking\MockClient;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::preventStrayRequests();
        MockClient::destroyGlobal();
        Nova::$tools = [];
        Nova::tools([new OhDearTool()]);
        Nova::auth(fn () => true);

        $this->actingAs(new User());
    }

    protected function tearDown(): void
    {
        MockClient::destroyGlobal();
        Nova::$tools = [];

        parent::tearDown();
    }

    protected function getPackageProviders($app): array
    {
        return [InertiaServiceProvider::class, NovaCoreServiceProvider::class, OhDearToolServiceProvider::class];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('nova-ohdear-tool.api_token', 'test-token');
        $app['config']->set('nova-ohdear-tool.monitor_id', 42);
        $app['config']->set('session.driver', 'array');
        $app['config']->set('app.key', 'base64:'.base64_encode(str_repeat('a', 32)));
        $app['config']->set('nova.middleware', ['web']);
    }
}
