<?php

namespace OhDear\OhDearTool\Http\Controllers;

use Illuminate\Http\Response;
use OhDear\PhpSdk\Dto\Monitor;
use OhDear\PhpSdk\OhDear;

class ChecksController
{
    public function enable(int $checkId, Monitor $monitor, OhDear $ohDear): Response
    {
        $this->authorizeCheck($monitor, $checkId);

        $ohDear->enableCheck($checkId);

        return response()->noContent();
    }

    public function disable(int $checkId, Monitor $monitor, OhDear $ohDear): Response
    {
        $this->authorizeCheck($monitor, $checkId);

        $ohDear->disableCheck($checkId);

        return response()->noContent();
    }

    public function requestRun(int $checkId, Monitor $monitor, OhDear $ohDear): Response
    {
        $this->authorizeCheck($monitor, $checkId);

        $ohDear->requestCheckRun($checkId);

        return response()->noContent();
    }

    protected function authorizeCheck(Monitor $monitor, int $checkId): void
    {
        abort_unless(collect($monitor->checks)->contains('id', $checkId), 404);
    }
}
