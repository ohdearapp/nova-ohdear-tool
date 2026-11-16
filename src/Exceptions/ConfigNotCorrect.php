<?php

namespace OhDear\OhDearTool\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ConfigNotCorrect extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json(['message' => $this->getMessage()], 503);
    }

    public static function apiTokenMissing(): self
    {
        return new self('Set OH_DEAR_API_TOKEN in your environment to connect to Oh Dear.');
    }

    public static function monitorIdMissing(): self
    {
        return new self('Set OH_DEAR_MONITOR_ID to a valid monitor ID in your environment.');
    }
}
