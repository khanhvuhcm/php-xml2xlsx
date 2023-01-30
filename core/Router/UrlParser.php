<?php

namespace Core\Router;

class UrlParser {
    public static function getUriParamPattern(string $route)
    {
        /**
         * @param route: /some/url/{param_1}/
         * @return array|null
         *
         * Extract all parameters enclosed within braces `{}`
         * and return an associative array with the parameters
         * indices within the URI path mapped to their name:
         * array (
         *  '1' => 'param_1',
         *  '3' => 'param_2'
         * )
         */
        $explodedUriPath = explode('/', $route);
        $paramMap = array();

        // Extract parameters
        $i = 0;
        foreach($explodedUriPath as $paramName) {
            if (
                str_split($paramName)[0] == '{' &&
                end(str_split($paramName)) == '}'
            ) {
                $parsedParamName = str_replace('}', '', str_replace('{', '', $paramName));
                $paramMap["$i"] = $parsedParamName;
            }

            // foreach ($paramMap as $key => $value)
            //     error_log("$key: $value");

            $i++;
        }

        return $paramMap;
    }

    public static function getParamsFromUri($uri, $routePattern) {
        $uri = rtrim($uri, '/');
        $explodedUri = explode('/', $uri);
        $params = array();

        foreach(self::getUriParamPattern($routePattern) as $paramNum => $paramName) {
            // print_r("Param name: $paramName <br>");
            // print_r("Param value in URI: $explodedUri[$paramNum] <br>");
            $params[$paramNum] = $explodedUri[$paramNum];
        }

        return $params;
    }

    public static function uriSimilarToRoute($route, $uri) {
        /**
         * Take in a URI with params, i.e /article/some-params-here/
         * and determine whether the provided URI matches the pattern
         * of its mapped route.
         * If the mapped route is '/article/{id}', then '/article/123' should match.
         */

        $route = rtrim($route, '/');
        $uri = rtrim($uri, '/');

        $routeSlashCount = count(explode('/', $route));
        $uriSlashCount = count(explode('/', $uri));

        if ($routeSlashCount == $uriSlashCount) return true;
        return false;


    }

};