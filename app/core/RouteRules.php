<?php

namespace app\core;

use app\core\base\BaseRoute;
use app\core\exception\NotFoundException;
use app\core\exception\WrongConfigurationException;
use Exception;

class RouteRules
{
    private static self $instance;

    /** @var $routes Route[] */
    private array $routes = [];

    /** @var $codeCatchers CodeCatcher[] */
    private array $codeCatchers = [];

    /**
     * Get singleton object
     */
    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function addRoute(Route $route): void
    {
        $this->routes[] = $route;
    }

    public function addCatcher(CodeCatcher $catcher, $onPageCode): void
    {
        $this->codeCatchers[$onPageCode] = $catcher;
    }

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function getCatcherForCode($code): ?CodeCatcher
    {
        return $this->codeCatchers[$code] ?? null;
    }

    /**
     * @param BaseRoute $route
     * @return $this
     */
    public function add(BaseRoute $route): RouteRules
    {
        $route->addToRouter($this);

        /* INSTEAD OF:
        if ($onPageCode = $route->getForPageCode()) {
            $this->codeCatchers[$onPageCode] = $route;
        } else {
            $this->routes[] = $route;
        } .....
        */
        return $this;
    }

    /**
     * @throws WrongConfigurationException
     * @throws NotFoundException
     */
    public function executeFor(WebRequest $request): void
    {
        foreach ($this->getRoutes() as $route) {
            if ($route->isMatchRequest($request)) {
                echo $route->executeRequest($request);
                return;
            }
        }

        throw new NotFoundException("Rule for URL: {$request->getUrl()} not found");
    }

    /**
     * @throws WrongConfigurationException
     * @throws Exception
     */
    public function responseException(?WebRequest $request, Exception $exception): void
    {
        $code = $exception->getCode();

        if ($rule = $this->getCatcherForCode($code)) {
            echo $rule->executeRequest($request);
            return;
        }

        throw $exception;
    }

    /**
     * Hide to prevent new
     */
    protected function __construct() { }

    /**
     * Disable clone
     */
    protected function __clone() { }

    /**
     * Prevent recover from string
     */
    public function __wakeup() { }
}
