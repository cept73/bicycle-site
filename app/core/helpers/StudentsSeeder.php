<?php

namespace app\core\helpers;

class StudentsSeeder
{
    public static function getTestUsersData(): array
    {
        /** @noinspection SpellCheckingInspection */
        $testUsersList = [
            [
                'user_name' => 'Bernardo Santini',
                'login'     => 'kctest00202',
                'title'     => '...',
                'group'     => 'Default group',
                'active'    => true,
            ],
            [
                'user_name' => 'George Quebedo',
                'login'     => 'kctest00213',
                'title'     => '...',
                'group'     => 'Default group',
                'active'    => true,
            ],
            [
                'user_name' => 'Rob Shneider',
                'login'     => 'kctest00208',
                'title'     => '...',
                'group'     => 'Default group',
                'active'    => true,
            ],
            [
                'user_name' => 'Terry Cruz',
                'login'     => 'kctest00220',
                'title'     => '...',
                'group'     => 'Default group',
                'active'    => false,
            ],
            [
                'user_name' => 'David Smith',
                'login'     => 'kctest00209',
                'title'     => '...',
                'group'     => 'Default group',
                'active'    => true,
            ],
        ];
        $testUsersList = array_merge($testUsersList, $testUsersList);

        return $testUsersList;
    }
}
