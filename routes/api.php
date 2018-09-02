<?php

Route::get('/sites', OhDear\OhDearTool\Http\Controllers\SitesController::class . '@index');
Route::get('/sites/{ohDearSiteId}', OhDear\OhDearTool\Http\Controllers\SitesController::class . '@show');