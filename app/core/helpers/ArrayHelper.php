<?php

namespace app\core\helpers;

class ArrayHelper
{
    public static function getPagesCount($length, $pageSize)
    {
        return ceil($length / $pageSize);
    }
}
