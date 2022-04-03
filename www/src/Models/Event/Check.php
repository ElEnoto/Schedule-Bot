<?php

namespace Otus\Models\Event;

use Otus\Log;
use Otus\Models\Connect\DbConnect;

class Check
{
    public static string $error = '';

    public static function checkAddContent(string $date, string $time):?string
    {
        $pdo = DbConnect::dbConnect();
        $result = $pdo->prepare('select id_event from events where date = ? and time = ?');
        $result->execute([$date, $time]);
        if ($result->fetchAll()) {
            Log::error('Event wasn\'t added or changed because of these data and time already exist');
            return self::$error = "Данные время и дата уже заняты другим событием";
        }
        return self::$error;
    }

    public static function checkChangeContent($change_id, string $date, string $time):?string
    {
        $pdo = DbConnect::dbConnect();
        $result = $pdo->prepare('select id_event from events where date = ? and time = ?');
        $result->execute([$date, $time]);
        $id = $result->fetchAll()[0]['id_event'];
        if ($id != $change_id) {
            Log::error('Event wasn\'t added or changed because of these data and time already exist');
            return self::$error = "Данные время и дата уже заняты другим событием";
        }
        return self::$error;
    }

}
