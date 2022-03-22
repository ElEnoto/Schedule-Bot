<?php
namespace Otus;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

Class Log {
    public static function notice($message, array $context = []) {
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler(__DIR__.'/Models/my_app.log', Logger::NOTICE));
        $log->notice($message, $context);
    }
    public static function error($message, array $context = []) {
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler(__DIR__.'/Models/my_app.log', Logger::ERROR));
        $log->error($message, $context);
    }
}

