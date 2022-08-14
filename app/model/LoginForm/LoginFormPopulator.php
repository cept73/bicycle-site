<?php

namespace app\model\LoginForm;

use app\core\WebRequest;

class LoginFormPopulator
{
    public static function populateFromRequest(LoginForm $form, WebRequest $request): LoginForm
    {
        $requestParams      = $request->getParams();
        $form->userName     = $requestParams['userName'] ?? '';
        $form->password     = $requestParams['password'] ?? '';
        $form->rememberMe   = $requestParams['rememberMe'] ?? false;

        return $form;
    }
}
