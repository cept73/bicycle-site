<?php

use app\core\base\DbConnection;
use app\core\Environment;
use app\model\UserSession\UserSession;

return [
    Environment::KEY_DB             => new DbConnection('mysql:host=localhost;dbname=city', 'root', 'password'),
    Environment::KEY_ITEMS_ON_PAGE  => 5,
    Environment::KEY_VIEW_PATH      => 'app/views',
    Environment::KEY_USER_STORE     => new UserSession(),
    Environment::KEY_SALT           => 'ygUuy',
    Environment::KEY_DEBUG          => true
];
