<?php

namespace app\core;

use app\core\base\BaseRoute;

/**
 * Rule for rote to page by URL
 */
class Route extends BaseRoute
{
    public function onGet($url): self
    {
        /** @var self $object */
        $object = self::newRule(WebRequest::METHOD_GET, $url);
        return $object;
    }

    public function onPost($url): self
    {
        /** @var self $object */
        $object = self::newRule(WebRequest::METHOD_POST, $url);
        return $object;
    }

    public function onDelete($url): self
    {
        /** @var self $object */
        $object = self::newRule(WebRequest::METHOD_DELETE, $url);
        return $object;
    }

    public function addToRouter(RouteRules $router): void
    {
        $router->addRoute($this);
    }
}
