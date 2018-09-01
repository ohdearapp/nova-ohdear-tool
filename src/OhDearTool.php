<?php

namespace OhDear\OhDearTool;

use Closure;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class OhDearTool extends Tool
{
    public function boot()
    {
        Nova::script('OhDearTool', __DIR__ . '/../dist/js/tool.js');
    }

    public function renderNavigation(): View
    {
        return view('OhDearTool::navigation');
    }
}
