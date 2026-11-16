<?php

namespace OhDear\OhDearTool\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use OhDear\PhpSdk\Dto\Monitor;

class MonitorsController
{
    public function show(Monitor $monitor): JsonResponse
    {
        return response()->json([
            'monitor' => [
                'id' => $monitor->id,
                'url' => $monitor->url,
                'label' => $monitor->label,
                'checks' => array_map(fn (array $check) => Arr::only($check, [
                    'id', 'type', 'label', 'enabled', 'latest_run_ended_at', 'latest_run_result', 'summary',
                ]), $monitor->checks),
            ],
        ]);
    }
}
