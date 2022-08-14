<?php

namespace app\core\base;

use app\core\Environment;
use app\core\exception\WrongConfigurationException;
use app\core\helpers\StringHelper;

abstract class BaseDataTable implements DataTableInterface
{
    /**
     * If null - autodetect by self class name
     *
     * @var string|null
     */
    public static ?string $table = null;

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
        $sql    = "SELECT * FROM $table WHERE uuid = :uuid";
        $params = ['uuid' => $uuid];

        return self::getConnection()->getOne($sql, $params);
    }

    public function validate(): bool
    {
        return true;
    }

    abstract public function save();
}
