<?php

namespace OhDear\OhDearTool\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use OhDear\OhDearTool\File;
use Illuminate\Support\Facades\File as IlluminateFile;
use OhDear\PhpSdk\OhDear;
use OhDear\PhpSdk\Resources\Site;
use Symfony\Component\Finder\SplFileInfo;

class CertificateHealthController
{
    public function show(int $siteId)
    {
        return [
            'certificate_health' => app(OhDear::class)->certificateHealth($siteId),
        ];
    }
}
