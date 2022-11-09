<?php

namespace app\core\base;

use app\core\App;
use app\core\Environment;
use app\core\helpers\DataTableHelper;
use app\core\helpers\StringHelper;
use Exception;

abstract class BaseDataTable implements DataTableInterface
{
    /**
     * If null - autodetect by self class name
     *
     * @var string|null
     */
    public static ?string $table = null;

    public string $uuid;

    protected static function getConnection(): BaseConnectionInterface
    {
        /** @var BaseConnectionInterface $db */
        $db = Environment::getParam(Environment::KEY_DB);

        return $db;
    }

    public static function getTable(): ?string
    {
        if (!static::$table) {
            $tableName = StringHelper::getTableNameByClassName(static::class);
            static::$table = $tableName;
        }

        return static::$table;
    }

    /** @noinspection SqlResolve */
    public static function getByUuid($uuid)
    {
        $table  = self::getTable();
        $sql    = "SELECT * FROM `$table` WHERE uuid = :uuid";
        $params = ['uuid' => $uuid];

        return self::getConnection()->getOne($sql, $params);
    }

    public function validate(): bool
    {
        return true;
    }

    /**
     * @throws Exception
     */
    public static function generateUuid(): string
    {
        do {
            $uuid = bin2hex(random_bytes(16));
        } while (self::getByUuid($uuid));

        return $uuid;
    }

    /** @noinspection SqlResolve */
    /**
     * @throws Exception
     */
    public function save(): void
    {
        $table = self::getTable();
        $props = array_keys(get_class_vars(self::class));

        $isExists = $this->uuid && self::getByUuid($this->uuid);
        if ($isExists) {
            $propertiesWithEqualSql = DataTableHelper::getPropertiesWithEqual($props);
            $sql = "UPDATE `$table` SET $propertiesWithEqualSql WHERE uuid=:uuid";
        } else {
            $propertiesList = DataTableHelper::getPropertiesString($props);
            $propertiesDottedList = DataTableHelper::getPropertiesDottedString($props);
            $this->uuid = self::generateUuid();
            $sql = "INSERT INTO `$table` ($propertiesList) VALUES ($propertiesDottedList)";
        }

        App::db()->execute($sql, DataTableHelper::getPropertiesToValues($props, $this));
    }
}
