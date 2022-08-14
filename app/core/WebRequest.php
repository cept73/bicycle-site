<?php

namespace app\core;

class WebRequest
{
    public const    CODE_ACCESS_DENIED = 403;
    public const    CODE_NOT_FOUND = 404;
    public const    CODE_FATAL     = 500;

    public const    METHOD_GET     = 'GET';
    public const    METHOD_POST    = 'POST';
    public const    METHOD_DELETE  = 'DELETE';

    private string  $url            = '';
    private array   $params         = [];
    private int     $code           = 200;
    private string  $method         = 'GET';

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function setParams(array $params): self
    {
        $this->params = $params;
        return $this;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;
        return $this;
    }

    public function __debugInfo(): array
    {
        return [
            'url'       => $this->url,
            'params'    => $this->params,
            'code'      => $this->code,
            'method'    => $this->method,
        ];
    }
}
