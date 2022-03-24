<?php

namespace Otus\Controllers;

use Otus\Log;

class RouteController
{
    protected static $routes = [
        'Hello/Hello-world' => ['Hello', 'world'],
        'Hi' => ['Hello', 'world']
    ];
    public static $controller_name = "Otus\\Controllers\\IndexController";
    public static $action_name = "action";

    public static function route()
    {
        try {
            $path = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");
            if (array_key_exists($path, self::$routes)) {
                $controller = self::$routes[$path][0];
                self::$controller_name = "Otus\\Controllers\\{$controller}Controller";
                self::$action_name = self::$routes[$path][1];
            } else {
                if ($path !== "") {
                    list($controller, $action) = explode("/", $path, 2);
                    if (isset($controller)) {
                        self::$controller_name = "Otus\\Controllers\\{$controller}Controller";
                    }
                    if (isset($action)) {
                        self::$action_name = $action;
                    }
                }
            }
        } catch (\Throwable $exception) {
            echo 'Something was wrong. We will fix it soon';
            Log::warning('We have a problem with Route!!!');
        }
    }
}
