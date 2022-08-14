<?php

namespace app\model\User;

use app\core\exception\InvalidModel;
use app\model\LoginForm\LoginForm;
use Exception;

class UserFactory
{
    /**
     * @throws InvalidModel
     * @throws Exception
     */
    public function registerByLoginForm(LoginForm $loginForm): User
    {
        $user = new User();
        UserPopulator::populate($user, $loginForm);
        $user->uuid = UserService::generateUuid();

        if ($user->validate()) {
            $user->save();
            return $user;
        }

        throw new InvalidModel($loginForm->getErrorsAsString());
    }
}
