<?php

namespace OhDear\OhDearTool\Http\Controllers;

use Illuminate\Routing\Controller;
use OhDear\PhpSdk\OhDear;

class SitesController extends Controller
{
    public function show()
    {
        $siteId = config('nova-ohdear-tool.site_id');

        $site = app(OhDear::class)->site($siteId);

        return compact('site');
    }
}
