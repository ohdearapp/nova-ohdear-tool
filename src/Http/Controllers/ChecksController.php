<?php

namespace OhDear\OhDearTool\Http\Controllers;

use OhDear\PhpSdk\OhDear;
use Illuminate\Support\Facades\Cache;

class ChecksController
{
    public function enable(int $checkId)
    {
        app(OhDear::class)->enableCheck($checkId);

        return 'ok';
    }

    public function disable(int $checkId)
    {
        app(OhDear::class)->disableCheck($checkId);

        return 'ok';
    }

    public function requestRun(int $checkId)
    {
        app(OhDear::class)->requestRun($checkId);

        return 'ok';
    }
}
