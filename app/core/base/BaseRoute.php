<?php

namespace app\core\base;

use app\core\Route;
use app\core\WebRequest;
use app\core\helpers\RequestHelper;
use app\core\exception\WrongConfigurationException;

abstract class BaseRoute implements RouterItemInterface
{
    private string  $method         = '';
    private string  $forUrl         = '';
    private array   $headers        = [];
    private ?string $toScript       = null;
    private ?string $callController = null;
    private ?string $callAction     = null;

    public static function newRule(string $method = '', string $url = ''): self
    {
        $route                  = new static;
        $route->method          = $method;
        $route->forUrl          = $url;
        return $route;
    }

    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;
        return $this;
    }

    public function call(string $callController, string $callAction): self
    {
        $this->callController   = $callController;
        $this->callAction       = $callAction;
        return $this;
    }

    /** @noinspection PhpUnused */
    public function runScript(string $toScript): self
    {
        $this->toScript = $toScript;
        return $this;
    }

    /**
     * @throws WrongConfigurationException
     */
    private function executeControllerMethodIfMatch(?WebRequest $request, ?Route $route): ?string
    {
        $controllerName = $this->getCallController();
        if ($controllerName) {
            $controller = new $controllerName;
            $actionName = $this->getCallAction();
            $method     = RequestHelper::getMethodNameByActionName($actionName);

            if (method_exists($controller, $method)) {
                return $controller->$method($request ?? null, $route);
            }

            throw new WrongConfigurationException("No method $method in $controllerName controller");
        }

        return null;
    }

    private function executeScriptIfMatch()
    {
        $runScript = $this->getToScript();
        if ($runScript && file_exists($runScript)) {
            ob_start();
            require $runScript;
            return ob_get_clean();
        }

        return null;
    }

    /**
     * @throws WrongConfigurationException
     */
    public function executeRequest(?WebRequest $request, $route = null): string
    {
        $result = $this->executeControllerMethodIfMatch($request, $route);
        if ($result !== null) {
            return $result;
        }

        $result = $this->executeScriptIfMatch();
        if ($result !== null) {
            return $result;
        }

        throw new WrongConfigurationException('No callControllerAction and toScript specified');
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getForUrl(): string
    {
        return $this->forUrl;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getToScript(): ?string
    {
        return $this->toScript;
    }

    public function getCallController(): ?string
    {
        return $this->callController;
    }

    public function getCallAction(): ?string
    {
        return $this->callAction;
    }
}
