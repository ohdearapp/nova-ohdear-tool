<?php

namespace OhDear\OhDearTool\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;
use OhDear\OhDearTool\OhDearTool;
use Symfony\Component\HttpFoundation\Response;

class Authorize
{
    /** @param Closure(Request): Response $next */
    public function handle(Request $request, Closure $next): Response
    {
        $tool = collect(Nova::registeredTools())->first(fn (Tool $tool) => $tool instanceof OhDearTool);

        abort_if($tool === null, 404);
        abort_unless($tool->authorize($request), 403);

        return $next($request);
    }
}
