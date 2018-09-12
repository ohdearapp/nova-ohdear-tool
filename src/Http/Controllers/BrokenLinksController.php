<?php

namespace OhDear\OhDearTool\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use OhDear\OhDearTool\File;
use Illuminate\Support\Facades\File as IlluminateFile;
use OhDear\PhpSdk\OhDear;
use OhDear\PhpSdk\Resources\Site;
use Symfony\Component\Finder\SplFileInfo;
use Illuminate\Routing\Controller;

class BrokenLinksController extends Controller
{
    /** @var \OhDear\PhpSdk\OhDear */
    protected $ohDear;

    public function __construct(OhDear $ohDear)
    {
        $this->ohDear = $ohDear;
    }

    public function show(int $siteId)
    {
        return [
            'brokenLinks' => $this->ohDear->brokenLinks($siteId),
        ];
    }
}
