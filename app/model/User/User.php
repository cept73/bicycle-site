<?php

namespace app\model\User;

use app\core\App;
use app\core\base\BaseDataTable;

class User extends BaseDataTable
{
    public static ?string $table = 'api_users';

    public string $uuid;
    public string $userName;
    public string $password;

    public function validate(): bool
    {
        if (empty($this->uuid)) {
            return false;
        }

        return true;
    }

    /** @noinspection SqlResolve */
    public function save(): void
    {
        $table = self::$table;

        $isExist = (bool) self::getByUuid($this->uuid);
        if ($isExist) {
            $sql = "UPDATE $table SET userName=:user_name, password=:password WHERE uuid=:uuid";
        } else {
            $sql = "INSERT INTO $table (uuid, user_name, password) VALUES (:uuid, :user_name, :password)";
        }

        App::db()->execute($sql, [
            ':uuid'         => $this->uuid,
            ':user_name'    => $this->userName,
            ':password'     => $this->password,
        ]);
    }
}
