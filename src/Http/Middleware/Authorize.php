<?php

namespace OhDear\OhDearTool\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use OhDear\OhDearTool\OhDearTool;
use Symfony\Component\HttpFoundation\Response;

class Authorize
{
    public function handle(Request $request, Closure $next): Response
    {
        return app(OhDearTool::class)->authorize($request)
            ? $next($request)
            : abort(403);
    }
}
