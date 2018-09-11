<?php

use OhDear\OhDearTool\Http\Controllers\SitesController;
use OhDear\OhDearTool\Http\Controllers\UptimeController;

Route::get('/sites', [SitesController::class, 'index']);
Route::get('/sites/{siteId}', [SitesController::class, 'show']);

Route::get('/uptime/{siteId}', [UptimeController::class, 'show']);