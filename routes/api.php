<?php

use OhDear\OhDearTool\Http\Controllers\BrokenLinksController;
use OhDear\OhDearTool\Http\Controllers\CertificateHealthController;
use OhDear\OhDearTool\Http\Controllers\MixedContentController;
use OhDear\OhDearTool\Http\Controllers\SitesController;
use OhDear\OhDearTool\Http\Controllers\UptimeController;

Route::get('/sites', [SitesController::class, 'index']);
Route::get('/sites/{siteId}', [SitesController::class, 'show']);

Route::get('/uptime/{siteId}', [UptimeController::class, 'show']);

Route::get('/mixed-content/{siteId}', [MixedContentController::class, 'show']);

Route::get('/broken-links/{siteId}', [BrokenLinksController::class, 'show']);

Route::get('/certificate-health/{siteId}', [CertificateHealthController::class, 'show']);