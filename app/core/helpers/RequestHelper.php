<?php

namespace app\core\helpers;

class RequestHelper
{
    public static function getCurrentURL(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public static function getCurrentURLPath(): string
    {
        return parse_url(self::getCurrentURL(), PHP_URL_PATH);
    }

    public static function getMethodNameByActionName(string $actionName): string
    {
        return 'action' . ucfirst($actionName);
    }
}
