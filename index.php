<?php /** @noinspection PhpUnhandledExceptionInspection */

/**
 * Bicycle joke framework
 * ------------------------------------------
 *
 * Copyright (c) 2022 by Cept
 */

use app\controllers\SiteController;
use app\core\Environment;
use app\core\CodeCatcher;
use app\core\RouteRules;
use app\core\Route;
use app\core\WebRequestFromUser;
require('vendor/autoload.php');

Environment::loadConfigFromFile('config/config');
session_start();

try {
    $webRequest = WebRequestFromUser::getFrom($_SERVER, $_REQUEST);

    $routeRules = RouteRules::getInstance()
        ->add((new Route)       ->onGet('/')             ->call(SiteController::class, 'homePage'))
        ->add((new Route)       ->onGet('/users')        ->call(SiteController::class, 'getUsersList'))
        ->add((new Route)       ->onGet('/dashboard')    ->call(SiteController::class, 'dashboard'))
        ->add((new Route)       ->onPost('/auth')        ->call(SiteController::class, 'auth'))
        ->add((new Route)       ->onDelete('/auth')      ->call(SiteController::class, 'deleteAuth'))
        ->add((new CodeCatcher) ->onPageNotFound('/assets')->call(SiteController::class, 'fileNotFound'))
        ->add((new CodeCatcher) ->onPageNotFound()           ->call(SiteController::class, 'pageNotFound'));

    $routeRules->executeFor($webRequest);
}
catch (Exception $exception) {
    RouteRules::getInstance()->responseException($webRequest ?? null, $exception);
}
