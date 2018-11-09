<?php

namespace OhDear\OhDearTool\Http\Controllers;

use OhDear\PhpSdk\OhDear;

class MixedContentController
{
    public function show(int $siteId)
    {
        return [
                'mixedContent' => app(OhDear::class)->mixedContent($siteId),
            ];
    }
}
