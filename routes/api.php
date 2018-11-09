<?php

use OhDear\OhDearTool\Http\Controllers\BrokenLinksController;
use OhDear\OhDearTool\Http\Controllers\CertificateHealthController;
use OhDear\OhDearTool\Http\Controllers\ChecksController;
use OhDear\OhDearTool\Http\Controllers\MixedContentController;
use OhDear\OhDearTool\Http\Controllers\SitesController;
use OhDear\OhDearTool\Http\Controllers\UptimeController;

Route::get('site', [SitesController::class, 'show']);

Route::prefix('checks/{checkId}')->group(function() {
    Route::post('enable', [ChecksController::class, 'enable']);
    Route::post('disable', [ChecksController::class, 'disable']);
    Route::post('request-run', [ChecksController::class, 'requestRun']);
});

Route::get('uptime/{siteId}', [UptimeController::class, 'show']);

Route::get('mixed-content/{siteId}', [MixedContentController::class, 'show']);

Route::get('broken-links/{siteId}', [BrokenLinksController::class, 'show']);

Route::get('certificate-health/{siteId}', [CertificateHealthController::class, 'show']);