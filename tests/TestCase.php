<?php

namespace OhDear\OhDearTool\Tests;

use Illuminate\Support\Facades\Route;
use OhDear\OhDearTool\OhDearToolServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function setUp()
    {
        parent::setUp();

        Route::middlewareGroup('nova', []);
    }

    protected function getPackageProviders($app)
    {
        return [
            OhDearToolServiceProvider::class,
        ];
    }
}
