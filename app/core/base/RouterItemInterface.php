<?php

namespace app\core\base;

use app\core\RouteRules;
use app\core\WebRequest;

interface RouterItemInterface
{
    public function addToRouter(RouteRules $router): void;

    public function executeRequest(WebRequest $request): string;
}
