<?php

namespace OhDear\OhDearTool\Http\Controllers;

use OhDear\PhpSdk\OhDear;

class BrokenLinksController
{
    public function show(int $siteId)
    {
        return [
            'brokenLinks' => app(OhDear::class)->brokenLinks($siteId),
        ];
    }
}
