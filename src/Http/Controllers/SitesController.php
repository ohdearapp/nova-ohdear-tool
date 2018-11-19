<?php

namespace OhDear\OhDearTool\Http\Controllers;

use OhDear\PhpSdk\OhDear;
use OhDear\PhpSdk\Resources\Site;
use Illuminate\Routing\Controller;

class SitesController extends Controller
{
    public function show()
    {
        $siteId = config('nova-ohdear-tool.site_id');

        $site = app(OhDear::class)->site($siteId);

        return compact('site');
    }
}
