<?php

namespace app\core;

use app\core\base\WebRequestInterface;
use app\core\helpers\RequestHelper;

/**
 * Adapter for WebRequest from real user request
 */
class WebRequestFromUser extends WebRequest implements WebRequestInterface
{
    /**
     * Use $_SERVER, $_REQUEST as a params
     *
     * @param array ...$params
     * @return WebRequest
     */
    public static function getFrom(...$params): WebRequest
    {
        [$server, $request] = $params;

        return (new WebRequest())
            ->setUrl(RequestHelper::getCurrentURLPath())
            ->setParams($request)
            ->setMethod($server['REQUEST_METHOD']);
    }
}
