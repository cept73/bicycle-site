<?php

namespace app\model\User;

use app\core\App;
use app\core\Environment;
use app\model\LoginForm\LoginForm;

class UserService
{
    private static function getSaltedPassword(string $password): string
    {
        $salt = Environment::getParam(Environment::KEY_SALT);
        return $salt . $password;
    }

    /* public static function getHashPassword(string $password): string
    {
        $saltedPassword = self::getSaltedPassword($password);
        return password_hash($saltedPassword, PASSWORD_DEFAULT);
    }*/

    public static function checkPassword(string $password, string $correctHash): bool
    {
        $saltedPassword = self::getSaltedPassword($password);
        return password_verify($saltedPassword, $correctHash);
    }

    private static function getHashedUserInfo(User $user): string
    {
        return $user->userName . self::getSaltedPassword($user->password);
    }

    public static function getHashedUserToken(User $user): string
    {
        return password_hash(self::getHashedUserInfo($user), PASSWORD_DEFAULT);
    }

    public static function checkHashedTokenForUser(string $token, User $user): bool
    {
        return password_verify(self::getHashedUserInfo($user), $token);
    }

    public static function signUserByLoginForm(LoginForm $loginForm): ?User
    {
        $userRepository = new UserRepository();

        $user = $userRepository->getUserByLoginPassword($loginForm->userName, $loginForm->password);
        if ($user) {
            App::loginAs($user);
            return $user;
        }

        return null;
    }
}
