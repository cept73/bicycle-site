<?php

namespace app\model\UserCookie;

use app\core\base\UserStoreInterface;
use app\model\User\User;
use app\model\User\UserRepository;
use app\model\User\UserService;

class UserCookie implements UserStoreInterface
{
    /**
     * Expiration: 2 weeks
     */
    public const EXPIRATION_TIME_MS = 60 * 60 * 24 * 14;

    public const KEY_USER_NAME  = 'member_login';
    public const KEY_TOKEN      = 'member_token';

    public function getCurrentUser(): ?User
    {
        $userName   = $_COOKIE[self::KEY_USER_NAME] ?? null;
        $token      = $_COOKIE[self::KEY_TOKEN] ?? null;

        return (new UserRepository())->getUserByLoginAndToken($userName, $token);
    }

    public function setCurrentUser(?User $user): void
    {
        $expiryDate = time() + self::EXPIRATION_TIME_MS;
        $userName   = $user->userName ?? null;
        $userToken  = $user ? UserService::getHashedUserToken($user) : null;

        setcookie(self::KEY_USER_NAME,  $userName,  $expiryDate);
        setcookie(self::KEY_TOKEN,      $userToken, $expiryDate);
    }
}
