<?php

namespace app\core;

use app\core\exception\WrongConfigurationException;
use app\core\helpers\FileHelper;

class Environment
{
    public const KEY_VIEW_PATH      = 'views';
    public const KEY_DB             = 'db';
    public const KEY_SALT           = 'salt';
    public const KEY_USER_STORE     = 'user-storage';
    public const KEY_ITEMS_ON_PAGE  = 'page-size';
    public const KEY_DEBUG          = 'debug';

    private static array $config;

    public static function loadConfig(array $config): void
    {
        self::$config = $config;
    }

    public static function loadConfigFromFile($fileName): void
    {
        $configurationParams =
            FileHelper::includeOrSkip("$fileName-local.php")
                ?: FileHelper::includeOrSkip("$fileName.php");

        if (!empty($configurationParams)) {
            self::loadConfig($configurationParams);
            return;
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        throw new WrongConfigurationException('Config is not found');
    }

    public static function getParam(string $param, $default = null)
    {
        return self::$config[$param] ?? $default;
    }
}
