<?php

namespace OhDear\OhDearTool;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;
use Illuminate\View\View;

class OhDearTool extends Tool
{
    public function boot()
    {
        Nova::script('OhDearTool', __DIR__.'/../dist/js/tool.js');
    }

    public function renderNavigation(): View
    {
        return view('OhDearTool::navigation');
    }
}
