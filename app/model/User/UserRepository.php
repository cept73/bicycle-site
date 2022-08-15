<?php /** @noinspection SqlResolve */

namespace app\model\User;

use app\core\App;

class UserRepository
{
    public function getUserInfoByLogin($userName)
    {
        $usersTable = User::getTable();
        $userInfo   = App::db()->getOne("SELECT * FROM $usersTable WHERE user_name = :user_name", [':user_name' => $userName]);

        return $userInfo;
    }

    public function getUserByLoginPassword($userName, $password): ?User
    {
        $userInfo = $this->getUserInfoByLogin($userName);
        if (!$userInfo || !UserService::checkPassword($password, $userInfo['password'])) {
            return null;
        }

        $user = new User();
        UserPopulator::populate($user, $userInfo);

        return $user;
    }

    public function getUserByLoginAndToken($userName, $token): ?User
    {
        $user       = new User();
        $userInfo   = $this->getUserInfoByLogin($userName);
        UserPopulator::populate($user, $userInfo);

        if (!$userInfo || !UserService::checkHashedTokenForUser($token, $user)) {
            return null;
        }

        return $user;
    }
}
