<?php

namespace app\core\base;

abstract class BaseRoute implements RouterItemInterface
{
    private string  $method = '';
    private string  $forUrl = '';
    private array   $headers = [];

    public static function newRule(string $method = '', string $url = ''): self
    {
        $route          = new static;
        $route->method  = $method;
        $route->forUrl  = $url;
        return $route;
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

    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;
        return $this;
    }
}
