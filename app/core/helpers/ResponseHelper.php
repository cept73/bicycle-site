<?php

namespace app\core\helpers;

class ResponseHelper
{
    public static function showHeaders($headers): string
    {
        foreach ($headers as $header) {
            header($header);
        }

        return '';
    }
}
