<?php /** @noinspection PhpUnused */

namespace app\model\Student;

use app\core\base\BaseDataTable;

class Student extends BaseDataTable
{
    public static ?string $table = 'students';

    public string $uuid;
    public string $userName;
    public string $login;
    public string $title;
    public string $group;
    public string $active;

    public function validate(): bool
    {
        if (empty($this->uuid)) {
            return false;
        }

        return true;
    }
}
