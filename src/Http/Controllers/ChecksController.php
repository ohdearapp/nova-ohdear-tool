<?php

namespace OhDear\OhDearTool\Http\Controllers;

use OhDear\PhpSdk\OhDear;
use Illuminate\Support\Facades\Cache;

class ChecksController
{
    public function enable(int $checkId)
    {
        $this->removeCache();

        app(OhDear::class)->enableCheck($checkId);

        return 'ok';
    }

    public function disable(int $checkId)
    {
        $this->removeCache();

        app(OhDear::class)->disableCheck($checkId);

        return 'ok';
    }

    public function requestRun(int $checkId)
    {
        app(OhDear::class)->requestRun($checkId);

        return 'ok';
    }

    public function removeCache()
    {
        $siteId = config('oh-dear-tool.sites.0.site_id');

        Cache::forget("oh-dear-site-{$siteId}");
    }
}
