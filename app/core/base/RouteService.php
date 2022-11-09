<?php

namespace app\core\base;

use app\core\Route;
use app\core\WebRequest;

class RouteService
{
    /**
     * Returns is request matches to the route
     *
     * @param WebRequest $request
     * @param Route $route
     * @return bool
     */
    public static function isRequestMatchRoute(WebRequest $request, Route $route): bool
    {
        $isMethodMatch = $request->getMethod() === $route->getMethod();
        if (!$isMethodMatch) {
            return false;
        }

        $params = self::getParamsForRequest($request, $route);
        if ($params === null) {
            return false;
        }
        if (!empty($params)) {
            return true;
        }

        return $route->getForUrl() === $request->getUrl();
    }

    /**
     * Get all params from specified request and current route rule
     *
     * @param WebRequest $request
     * @param Route $route
     * @return array|null
     */
    public static function getParamsForRequest(WebRequest $request, Route $route): ?array
    {
        $routeRuleUrl   = $route->getForUrl();
        $requestUrl     = $request->getUrl();

        if (empty($variables = self::getAllVariablesInRouteRuleUrl($routeRuleUrl))) {
            return [];
        }

        $pattern = self::getRegularPatternForRouteRuleUrl($routeRuleUrl, $variables);
        return self::getPatternMatchesParams($routeRuleUrl, $pattern, $requestUrl);
    }

    /**
     * Search all specified variables in route rule URL
     *
     * @param string $string
     * @return array|null
     */
    private static function getAllVariablesInRouteRuleUrl(string $string): ?array
    {
        preg_match_all('/\{\s*([^}\s]*)\s*}/', $string, $quotes);

        return $quotes[1] ?? null;
    }

    /**
     * Prepare regular pattern string to match this route URL
     *
     * @param string $routeRuleUrl
     * @param array $variables
     * @return string
     */
    private static function getRegularPatternForRouteRuleUrl(string $routeRuleUrl, array $variables): string
    {
        $routeRegularUrl = "`$routeRuleUrl$`m";
        foreach ($variables as $variable) {
            $routeRegularUrl = str_replace('{' . $variable . '}', '(\w+)', $routeRegularUrl);
        }

        return $routeRegularUrl;
    }

    /**
     * Null - if URL does not match pattern
     * Otherwise returns [] or ['key' => 'val', ...]
     *
     * @param $routeRuleUrl
     * @param $routeRegularUrl
     * @param $requestUrl
     * @return array|null
     */
    private static function getPatternMatchesParams($routeRuleUrl, $routeRegularUrl, $requestUrl): ?array
    {
        if (1 !== preg_match_all($routeRegularUrl, $requestUrl, $variableValues, PREG_OFFSET_CAPTURE)) {
            return null;
        }

        $params = [];
        foreach ($variableValues as $variableValue) {
            [$value, $position] = $variableValue[0];
            if ($key = self::getVariableNameAtPos($routeRuleUrl, $position)) {
                $params[$key] = $value;
            }
        }
        return $params;
    }

    /**
     * Read variable name at specified position
     * For example, for "{x}" returns 'x'
     *
     * @param $string
     * @param $index
     * @return string|null
     */
    private static function getVariableNameAtPos($string, $index): ?string
    {
        if ($string[$index] === '{') {
            $endPos = strpos($string, '}', $index) ?: strlen($string) + 1;
            return substr($string, $index + 1, $endPos - $index - 1);
        }

        return null;
    }
}
