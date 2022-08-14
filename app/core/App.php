<?php

namespace app\core;

use app\core\base\BaseConnectionInterface;
use app\core\base\UserStoreInterface;
use app\model\User\User;
use app\model\UserCookie\UserCookie;

/**
 * Application Facade for needs
 */
class App
{
    /**
     * @return BaseConnectionInterface
     */
    public static function db(): BaseConnectionInterface
    {
        return Environment::getParam(Environment::KEY_DB);
    }

    public static function userStorage(): UserStoreInterface
    {
        return Environment::getParam(Environment::KEY_USER_STORE);
    }

    public static function cookie(): UserCookie
    {
        return new UserCookie();
    }

    public static function currentUser(): ?User
    {
        return self::userStorage()->getCurrentUser();
    }

    public static function loginAs(User $user)
    {
        return self::userStorage()->setCurrentUser($user);
    }
}
