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
        $currentUrl = self::getCurrentURL();
        if ($divider = strpos($currentUrl, '?')) {
            $currentUrl = substr($currentUrl, 0, $divider);
        }
        return $currentUrl;
    }

    public static function getCurrentRequestMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function getMethodNameByActionName(string $actionName): string
    {
        return 'action' . ucfirst($actionName);
    }
}
