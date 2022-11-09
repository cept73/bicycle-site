<?php

namespace app\core;

use app\core\base\BaseRoute;

/**
 * Rule for rote to page if event
 */
class CodeCatcher extends BaseRoute
{
    private ?string $pageCode = null;

    /**
     * @param int $pageCode
     * @return self
     */
    private function forPageCode(int $pageCode): self
    {
        $this->pageCode = $pageCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getForPageCode(): ?string
    {
        return $this->pageCode;
    }

    public function onPageNotFound($url = ''): self
    {
        /** @var self $rule */
        $rule = self::newRule(WebRequest::METHOD_GET, $url);

        return $rule
            ->forPageCode(WebRequest::CODE_NOT_FOUND)
            ->setHeaders(['HTTP/1.1 404 Not Found']);
    }

    public function onAccessDenied(): self
    {
        /** @var self $rule */
        $rule = self::newRule(WebRequest::METHOD_GET);

        return $rule
            ->forPageCode(WebRequest::CODE_ACCESS_DENIED)
            ->setHeaders(['HTTP/1.1 403 Forbidden']);
    }

    public function addToRouter(RouteRules $router): void
    {
        $onPageCode = $this->getForPageCode();
        $router->addCatcher($this, $onPageCode);
    }
}
