<?php

namespace OhDear\OhDearTool\Exceptions;

use Exception;

class ConfigNotCorrect extends Exception
{
    public static function apiTokenMissing(): Exception
    {
        return new static('You should specify an `api_token` in the `oh-dear-tool` config file');
    }
}