<?php

use Illuminate\Support\Facades\Route;
use Inertia\Response;

Route::inertia('/', 'OhDearOverview')->name('ohDear.overview');

Route::get('{report}', fn (string $report): Response => inertia('OhDearReport', ['report' => $report]))
    ->whereIn('report', ['uptime', 'broken-links', 'mixed-content', 'certificate-health'])
    ->name('ohDear.report');
