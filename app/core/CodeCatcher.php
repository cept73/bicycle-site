<?php

namespace app\core;

use app\core\base\BaseRoute;
use app\core\base\ControllerTrait;

/**
 * Rule for rote to page if event
 */
class CodeCatcher extends BaseRoute
{
    use ControllerTrait;

    private ?string $forPageCode = null;

    /**
     * @param int $pageCode
     * @return $this
     */
    private function forPageCode(int $pageCode): self
    {
        $this->forPageCode = $pageCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getForPageCode(): ?string
    {
        return $this->forPageCode;
    }

    public function onPageNotFound($url = ''): self
    {
        /** @var self $rule */
        $rule = self::newRule(WebRequest::METHOD_GET, $url);

        return $rule
            ->forPageCode(WebRequest::CODE_NOT_FOUND)
            ->setHeaders(['HTTP/1.1 404 Not Found']);
    }

    public function addToRouter(RouteRules $router): void
    {
        $onPageCode = $this->getForPageCode();
        $router->addCatcher($this, $onPageCode);
    }

    public function isMatchRequest(WebRequest $request): bool
    {
        return $request->getCode() === $this->getForPageCode();
    }
}
