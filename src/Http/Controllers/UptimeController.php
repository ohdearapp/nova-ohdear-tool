<?php

namespace OhDear\OhDearTool\Http\Controllers;

use Illuminate\Http\JsonResponse;
use OhDear\PhpSdk\Dto\Monitor;
use OhDear\PhpSdk\Enums\UptimeSplit;
use OhDear\PhpSdk\OhDear;

class UptimeController
{
    public function show(Monitor $monitor, OhDear $ohDear): JsonResponse
    {
        $now = now()->utc();
        $weekAgo = $now->copy()->subDays(7)->toDateTimeString();
        $yearAgo = $now->copy()->subYear()->toDateTimeString();
        $until = $now->toDateTimeString();

        return response()->json([
            'uptimePastWeek'  => $ohDear->uptime($monitor->id, $weekAgo, $until, UptimeSplit::Day),
            'uptimePastYear'  => $ohDear->uptime($monitor->id, $yearAgo, $until, UptimeSplit::Month),
            'downtimePeriods' => $ohDear->downtime($monitor->id, $weekAgo, $until),
        ]);
    }
}
