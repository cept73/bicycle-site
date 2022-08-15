<?php

namespace app\model\User;

use app\core\base\BaseDataTable;

class User extends BaseDataTable
{
    public static ?string $table = 'api_users';

    public string $uuid;
    public string $userName;
    public string $password;

    public function validate(): bool
    {
        if (empty($this->userName)) {
            return false;
        }

        return true;
    }
}
