<?php

namespace OhDear\OhDearTool\Http\Controllers;

class ChecksController
{
    /** @var \OhDear\PhpSdk\OhDear */
    protected $ohDear;

    public function __construct(OhDear $ohDear)
    {
        $this->ohDear = $ohDear;
    }

    public function enable(int $checkId)
    {
        return $this->ohDear->enableCheck($checkId);
    }

    public function disable(int $checkId)
    {
        return $this->ohDear->disableCheck($checkId);
    }

    public function requestRun(int $checkId)
    {
        return $this->ohDear->requestRun($checkId);
    }
}