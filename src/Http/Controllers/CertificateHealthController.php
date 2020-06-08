<?php

namespace OhDear\OhDearTool\Http\Controllers;

use OhDear\PhpSdk\OhDear;

class CertificateHealthController
{
    public function show(int $siteId)
    {
        return [
            'certificate_health' => app(OhDear::class)->certificateHealth($siteId),
        ];
    }
}
