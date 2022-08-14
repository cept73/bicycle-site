<?php

namespace app\model\User;

class UserPopulator
{
    public static function populate(User $user, $data): User
    {
        $user->uuid     = $data['uuid'] ?? '';
        $user->userName = $data['user_name'] ?? '';
        $user->password = $data['password'] ?? '';

        return $user;
    }
}
