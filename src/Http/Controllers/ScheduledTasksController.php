<?php

namespace OhDear\OhDearTool\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use OhDear\PhpSdk\Dto\CronCheckDefinition;
use OhDear\PhpSdk\Dto\Monitor;
use OhDear\PhpSdk\OhDear;

class ScheduledTasksController
{
    public function index(Monitor $monitor, OhDear $ohDear): JsonResponse
    {
        return response()->json([
            'scheduledTasks' => array_map(fn (CronCheckDefinition $task) => Arr::only((array) $task, [
                'id', 'name', 'description', 'frequencyInMinutes', 'graceTimeInMinutes',
                'cronExpression', 'humanReadableCronExpression', 'serverTimezone',
                'latestResult', 'latestResultLabel', 'latestResultLabelColor', 'latestPingAt',
            ]) + ['snoozed' => $task->activeSnooze !== null], iterator_to_array($ohDear->cronCheckDefinitions($monitor->id), false)),
        ]);
    }
}
