<?php /** @noinspection SqlResolve */

namespace app\model\Student;

use app\core\App;

class StudentRepository
{
    public function getPage(int $page, int $pageSize): array
    {
        $usersTable = Student::getTable();
        $firstIndex = $pageSize * ($page - 1);
        $usersList  = App::db()->getAll("SELECT * FROM `$usersTable` LIMIT $firstIndex, $pageSize");

        return $usersList;

    }

    public function getCount()
    {
        $usersTable = Student::getTable();
        $usersCount = App::db()->getOne("SELECT count(*) AS c FROM `$usersTable`");

        return $usersCount['c'];
    }
}
