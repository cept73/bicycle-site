<?php

namespace app\core\helpers;

class FileHelper
{
    public static function includeOrSkip(string $fileName): ?array
    {
        if (file_exists($fileName)) {
            return include $fileName;
        }

        return null;
    }

    public static function getFileNameWithoutPath(string $fileName): string
    {
        return basename($fileName);
    }
}
