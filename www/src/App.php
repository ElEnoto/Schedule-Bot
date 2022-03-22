<?php

namespace Otus;
use Otus\Controllers\RouteController;

class App {
    public static function run():void
    {
        RouteController::route();
        $controller_name = RouteController::$controller_name;
        $action_name = RouteController::$action_name;
        if(!class_exists($controller_name,true) or !method_exists($controller_name, $action_name)) {
            $view = new View('Something wrong', '404 - Not Foud', "");
            $view->template();
        } else {
            $controller = new $controller_name();
            $controller->$action_name();
        }
    }
}