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
//    public static function CheckChangeContent($id, $club_name, $format_name, $date, $time, $cost, $comment)
//    {
//        $pdo = DbConnect::db_connect();
//        $result = $pdo->prepare('select id_event, club_name, format_name, date, time, cost, comment from events JOIN clubs ON events.id_club = clubs.id_club JOIN formats ON events.id_format = formats.id_format where id_event = ? and club_name = ?, and format_name = ?, and date = ?, and time = ?, and cost = ?, and comment = ?');
//        $result->execute([$id, $club_name, $format_name, $date, $time, $cost, $comment]);
//        if($result->fetchAll())
//            return self::$error = "Данные не изменились";
//    }
}
//update events set id_club = (select id_club from clubs where club_name like ?), id_format = (select id_format from formats where format_name like ?), date = ?, time = ?, cost = ?, comment = ? where id_event = like ?"