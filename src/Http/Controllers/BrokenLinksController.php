<?php

namespace OhDear\OhDearTool\Http\Controllers;

use Illuminate\Http\JsonResponse;
use OhDear\PhpSdk\Dto\Monitor;
use OhDear\PhpSdk\OhDear;

class BrokenLinksController
{
    public function show(Monitor $monitor, OhDear $ohDear): JsonResponse
    {
        return response()->json([
            'brokenLinks' => iterator_to_array($ohDear->brokenLinks($monitor->id), false),
        ]);
    }
}
