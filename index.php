<?php

/** @noinspection PhpUnhandledExceptionInspection */

/**
 * Bicycle joke framework
 * ------------------------------------------
 *
 * Copyright (c) 2022 by Cept
 */

use app\core\Environment;
use app\controllers\SiteController as SC;
use app\core\CodeCatcher;
use app\core\RouteRules;
use app\core\Route;
use app\core\WebRequestFromUser;
require('vendor/autoload.php');

Environment::loadConfigFromFile('config/config');

try {
    $webRequest = WebRequestFromUser::getFrom($_SERVER, $_REQUEST);

    RouteRules::getInstance()
        ->add((new Route())     ->onGet('/')                    ->call(SC::class, 'homePage'))
        ->add((new Route())     ->onGet('/students/page/{page}')->call(SC::class, 'getStudentsList'))
        ->add((new Route())     ->onGet('/dashboard')           ->call(SC::class, 'dashboard'))
        ->add((new Route())     ->onPost('/auth')               ->call(SC::class, 'auth'))
        ->add((new Route())     ->onDelete('/auth')             ->call(SC::class, 'deleteAuth'))
        ->add((new CodeCatcher())->onPageNotFound('/assets')    ->call(SC::class, 'fileNotFound'))
        ->add((new CodeCatcher())->onPageNotFound()                 ->call(SC::class, 'pageNotFound'))
        ->add((new CodeCatcher())->onAccessDenied()                 ->call(SC::class, 'accessDenied'))
        ->executeFor($webRequest);

} catch (Exception $exception) {
    RouteRules::getInstance()->responseException($webRequest ?? null, $exception);
}
