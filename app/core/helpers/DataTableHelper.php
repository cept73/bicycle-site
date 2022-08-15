<?php

namespace app\core\helpers;

use app\core\base\BaseDataTable;

class DataTableHelper
{
    public static function getPropertiesWithEqual($properties): string
    {
        $addEqualFunction = static function ($name) {
            return "$name = :$name";
        };

        return implode(', ', array_map($addEqualFunction, $properties));

    }

    public static function getPropertiesString($properties): string
    {
        return implode(', ', $properties);
    }

    public static function getPropertiesDottedList($properties): array
    {
        $addDotFunction = static function ($name) {
            return ":$name";
        };

        return array_map($addDotFunction, $properties);
    }

    public static function getPropertiesDottedString($properties): string
    {
        return implode(', ', self::getPropertiesDottedList($properties));
    }

    public static function getPropertiesToValues($properties, BaseDataTable $object): array
    {
        $addValueFunction = static function ($name) use ($object) {
            return $object->$name;
        };

        $propertiesWithDots = self::getPropertiesDottedList($properties);

        return array_map($addValueFunction, $propertiesWithDots);
    }
}
