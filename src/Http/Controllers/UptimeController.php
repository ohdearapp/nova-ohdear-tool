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
    public function show(int $siteId)
    {
        return Cache::remember("oh-dear-broken-uptime-{$siteId}", 1, function () use ($siteId) {

            return [
                'uptimePastWeek' => app(OhDear::class)->uptime(
                    $siteId,
                    now()->subDays(7)->format('YmdHis'),
                    now()->format('YmdHis'),
                    'day'
                ),
                'uptimePastYear' => app(OhDear::class)->uptime(
                    $siteId,
                    now()->subYear()->format('YmdHis'),
                    now()->format('YmdHis'),
                    'month'
                ),
                'downtimePeriods' => app(OhDear::class)->downtime(
                    $siteId,
                    now()->subDays(7)->format('YmdHis'),
                    now()->format('YmdHis')
                )
            ];
        });
    }
}
