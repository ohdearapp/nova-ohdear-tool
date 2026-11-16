<?php

namespace OhDear\OhDearTool\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use OhDear\PhpSdk\Dto\ApplicationHealthCheck;
use OhDear\PhpSdk\Dto\ApplicationHealthCheckHistoryItem;
use OhDear\PhpSdk\Dto\Monitor;
use OhDear\PhpSdk\OhDear;

class ApplicationHealthChecksController
{
    public function index(Monitor $monitor, OhDear $ohDear): JsonResponse
    {
        return response()->json([
            'healthChecks' => array_map(fn (ApplicationHealthCheck $check) => Arr::only((array) $check, [
                'id', 'name', 'label', 'status', 'message', 'shortSummary', 'detectedAt', 'updatedAt',
            ]) + ['snoozed' => $check->activeSnooze !== null], $ohDear->applicationHealthChecks($monitor->id)),
        ]);
    }

    public function show(Monitor $monitor, OhDear $ohDear, int $healthCheckId): JsonResponse
    {
        $check = collect($ohDear->applicationHealthChecks($monitor->id))->firstWhere('id', $healthCheckId);

        abort_unless($check, 404);

        return response()->json([
            'healthCheck' => ['id' => $check->id, 'label' => $check->label],
            'history' => array_map(fn (ApplicationHealthCheckHistoryItem $item) => Arr::only((array) $item, [
                'id', 'status', 'shortSummary', 'message', 'detectedAt', 'updatedAt',
            ]), $ohDear->applicationHealthCheckHistory($monitor->id, $healthCheckId)),
        ]);
    }
}
