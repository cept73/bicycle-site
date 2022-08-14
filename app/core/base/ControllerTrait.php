<?php

namespace app\core\base;

use app\core\exception\WrongConfigurationException;
use app\core\helpers\RequestHelper;
use app\core\WebRequest;
use app\model\User\User;
use app\model\UserSession\UserSession;

trait ControllerTrait
{
    private ?string $toScript       = null;
    private ?string $callController = null;
    private ?string $callAction     = null;
    private ?User $user;

    public function getCurrentUser(): ?User
    {
        return (new UserSession())->getCurrentUser();
    }

    private function preparedController(BaseController $controller): BaseController
    {
        return $controller;
    }

    /**
     * @throws WrongConfigurationException
     */
    private function executeControllerMethodIfMatch(?WebRequest $request): ?string
    {
        $controllerName = $this->getCallController();
        if ($controllerName) {
            $controller = new $controllerName;
            $actionName = $this->getCallAction();
            $method     = RequestHelper::getMethodNameByActionName($actionName);

            if (method_exists($controller, $method)) {
                return $controller->$method($request ?? null, $this);
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
    public function executeRequest(?WebRequest $request): string
    {
        $result = $this->executeControllerMethodIfMatch($request);
        if ($result !== null) {
            return $result;
        }

        $result = $this->executeScriptIfMatch();
        if ($result !== null) {
            return $result;
        }

        throw new WrongConfigurationException('No callControllerAction and toScript specified');
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
