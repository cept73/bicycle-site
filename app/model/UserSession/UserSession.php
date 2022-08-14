<?php

namespace app\model\UserSession;

use app\core\base\UserStoreInterface;
use app\model\User\User;

class UserSession implements UserStoreInterface
{
    public const KEY_USER = 'user';

    public function getCurrentUser(): ?User
    {
        return $_SESSION[self::KEY_USER] ?? null;
    }

    public function setCurrentUser(?User $user): void
    {
        $_SESSION[self::KEY_USER] = $user;
    }
}
