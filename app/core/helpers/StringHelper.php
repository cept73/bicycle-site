<?php

namespace app\core\helpers;

class StringHelper
{
    public static function getTableNameByClassName($className): string
    {
        $lastDivider = strrpos($className, '\\');
        if ($lastDivider) {
            $className = substr($className, $lastDivider + 1);
        }

        return strtolower($className);
    }

    public static function isEnglishLettersText(string $string): bool
    {
        return preg_match('/[^A-Za-z]+/', $string);
    }
}
