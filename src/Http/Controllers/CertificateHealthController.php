<?php

namespace OhDear\OhDearTool\Http\Controllers;

use Illuminate\Http\JsonResponse;
use OhDear\PhpSdk\Dto\Monitor;
use OhDear\PhpSdk\OhDear;

class CertificateHealthController
{
    public function show(Monitor $monitor, OhDear $ohDear): JsonResponse
    {
        return response()->json([
            'certificateHealth' => $ohDear->certificateHealth($monitor->id),
        ]);
    }
}
