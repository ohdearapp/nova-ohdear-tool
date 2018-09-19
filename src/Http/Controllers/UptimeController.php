<?php

namespace OhDear\OhDearTool\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use OhDear\OhDearTool\File;
use Illuminate\Support\Facades\File as IlluminateFile;
use OhDear\PhpSdk\OhDear;
use OhDear\PhpSdk\Resources\Site;
use Symfony\Component\Finder\SplFileInfo;

class UptimeController
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
            'uptimePastWeek' => $this->ohDear->uptime(
                $siteId,
                now()->subDays(7)->format('YmdHis'),
                now()->format('YmdHis'),
                'day'
            ),
            'uptimePastYear' => $this->ohDear->uptime(
                $siteId,
                now()->subYear()->format('YmdHis'),
                now()->format('YmdHis'),
                'month'
            ),
            'downtimePeriods' => $this->ohDear->downtime(
                $siteId,
                now()->subDays(7)->format('YmdHis'),
                now()->format('YmdHis')
            )
        ];
    }
}
