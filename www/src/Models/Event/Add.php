<?php
namespace Otus\Models\Event;

use Otus\Log;
use Otus\Models\Connect\DbConnect;

class Add
{
    public static function add_event(array $add_content):void
    {
        $pdo = DbConnect::db_connect();
        $club_name = $add_content['club_name'];
        $format_name = $add_content['format_name'];
        $date = $add_content['date'];
        $time = $add_content['time'];
        $cost = $add_content['cost'];
        $comment = $add_content['comment'];
        $result = $pdo->prepare("insert into events (id_club, id_format, date, time, cost, comment) values ((select id_club from clubs where club_name like ?), (select id_format from formats where format_name like ?), ?, ?, ?, ?)");
//            Log::notice('Task was added', ['id' => $id]);
        $result->execute([$club_name, $format_name, $date, $time, $cost, $comment]);
//        try {
//            $pdo = DbConnect::db_connect();
//            $club_name = $add_content['club_name'];
//            $format_name = $add_content['format_name'];
//            $date = $add_content['date'];
//            $time = $add_content['time'];
//            $cost = $add_content['cost'];
//            $comment = $add_content['comment'];
//            $result = $pdo->prepare("insert into events (id_club, id_format, date, time, cost, comment) values ((select id_club from clubs where club_name like '$club_name'), (select id_format from formats where format_name like '$format_name'), ?, ?, ?, ?)");
////            Log::notice('Task was added', ['id' => $id]);
//            $result->execute([$date, $time, $cost, $comment]);
//        } catch (\Throwable $exception){
//            echo 'Something was wrong. We will fix it soon';
//        }
    }
}
