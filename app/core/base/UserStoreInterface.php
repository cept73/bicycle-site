<?php

namespace app\core\base;

use app\model\User\User;

interface UserStoreInterface
{
    public function getCurrentUser(): ?User;

    public function setCurrentUser(?User $user);
}
