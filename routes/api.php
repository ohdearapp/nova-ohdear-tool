<?php

use Illuminate\Support\Facades\Route;
use OhDear\OhDearTool\Http\Controllers\BrokenLinksController;
use OhDear\OhDearTool\Http\Controllers\CertificateHealthController;
use OhDear\OhDearTool\Http\Controllers\ChecksController;
use OhDear\OhDearTool\Http\Controllers\MixedContentController;
use OhDear\OhDearTool\Http\Controllers\MonitorsController;
use OhDear\OhDearTool\Http\Controllers\UptimeController;

Route::get('monitor', [MonitorsController::class, 'show']);
Route::get('uptime', [UptimeController::class, 'show']);
Route::get('mixed-content', [MixedContentController::class, 'show']);
Route::get('broken-links', [BrokenLinksController::class, 'show']);
Route::get('certificate-health', [CertificateHealthController::class, 'show']);

Route::prefix('checks/{checkId}')->whereNumber('checkId')->group(function () {
    Route::post('enable', [ChecksController::class, 'enable']);
    Route::post('disable', [ChecksController::class, 'disable']);
    Route::post('request-run', [ChecksController::class, 'requestRun']);
});
