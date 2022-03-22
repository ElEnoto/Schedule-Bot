<?php

namespace Otus\Models\Event;

use Otus\Models\Connect\DbConnect;

class Check
{
    public static string $error = '';
    public static function CheckAddContent($date, $time)
    {
        $pdo = DbConnect::db_connect();
        $result = $pdo->prepare('select id_event from events where date = ? and time = ?');
        $result->execute([$date, $time]);
        if($result->fetchAll())
            return self::$error = "Данные время и дата уже заняты другим событием";
    }
}