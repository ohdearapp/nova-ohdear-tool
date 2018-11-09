<?php

namespace OhDear\OhDearTool\Http\Controllers;

use OhDear\PhpSdk\OhDear;

class UptimeController
{
    public function show(int $siteId)
    {
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
            ),
        ];
    }
}
