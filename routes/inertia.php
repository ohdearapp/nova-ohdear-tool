<?php

use Illuminate\Support\Facades\Route;
use Inertia\Response;

Route::inertia('/', 'OhDearOverview')->name('ohDear.overview');

Route::get('application-health/{healthCheckId}', fn (int $healthCheckId): Response => inertia('OhDearReport', [
    'report' => 'application-health', 'healthCheckId' => $healthCheckId,
]))->whereNumber('healthCheckId')->name('ohDear.healthHistory');

Route::get('{report}', fn (string $report): Response => inertia('OhDearReport', ['report' => $report]))
    ->whereIn('report', ['uptime', 'broken-links', 'mixed-content', 'certificate-health', 'application-health', 'scheduled-tasks'])
    ->name('ohDear.report');
