<?php

namespace OhDear\OhDearTool;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class OhDearTool extends Tool
{
    public function boot(): void
    {
        Nova::script('oh-dear-tool', __DIR__.'/../dist/js/tool.js');
        Nova::style('oh-dear-tool', __DIR__.'/../dist/css/tool.css');
    }

    public function menu(Request $request): MenuSection
    {
        return MenuSection::make('Oh Dear')
            ->path('/oh-dear')
            ->icon('status-online');
    }
}
