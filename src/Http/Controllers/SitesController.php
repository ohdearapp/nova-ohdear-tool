<?php

namespace OhDear\OhDearTool\Http\Controllers;

use Illuminate\Http\Request;
use OhDear\OhDearTool\File;
use Illuminate\Support\Facades\File as IlluminateFile;
use OhDear\PhpSdk\OhDear;
use OhDear\PhpSdk\Resources\Site;
use Symfony\Component\Finder\SplFileInfo;
use Illuminate\Routing\Controller;

class SitesController extends Controller
{
    public function index()
    {
        return config('oh-dear-tool.sites');
    }

    public function show(int $siteId)
    {
        \Log::info('in show method');

        $site = $this->getSite($siteId);

        return [
            'site' => $site,
            'brokenLinks' => $site->brokenLinks(),
            'mixedContent' => $site->mixedContent(),
        ];
    }

    protected function getSite(int $siteId): Site
    {
        return app(OhDear::class)->site($siteId);
    }


}
