<?php

namespace app\core\base;

use app\core\WebRequest;

/**
 * For WebRequest adapters
 */
interface WebRequestInterface
{
    public static function getFrom(...$params): WebRequest;
}
