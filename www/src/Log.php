<?php

namespace Otus;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Log
{
    public static function notice(string $message, array $context = [])
    {
        $log = new Logger('notice');
        $log->pushHandler(new StreamHandler(__DIR__ . '/my_bot.log', Logger::NOTICE));
        $log->notice($message, $context);
    }

    public static function error(string $message, array $context = [])
    {
        $log = new Logger('error');
        $log->pushHandler(new StreamHandler(__DIR__ . '/my_bot.log', Logger::ERROR));
        $log->error($message, $context);
    }

    public static function warning(string $message, array $context = [])
    {
        $log = new Logger('warning');
        $log->pushHandler(new StreamHandler(__DIR__ . '/my_bot.log', Logger::WARNING));
        $log->error($message, $context);
    }
}

