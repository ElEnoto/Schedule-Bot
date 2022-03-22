<?php

namespace Otus\Models\Event;

use Otus\Log;
use Otus\Models\Connect\DbConnect;

class FindChangeContent
{
    public static string $club_name;
    public static string $format_name;
    public static string $date = '';
    public static string $time;
    public static string $cost;
    public static string $comment;
    public static string $error = '';
    public static  $changeId;
    public static array $change_content = [];
    public static function findChangeID()
    {
        if (empty ($_POST['id_event']) and empty ($_POST['change'])){
            return self::$changeId;
        }
        if (!empty ($_POST['id_event']) and !empty ($_POST['change'])) {
            if(count($_POST['id_event']) > 1){
                self::$error = 'Одновременно можно редактировать только одно событие';
                return self::$error;
            }
            self::$changeId = $_POST['id_event'];
            return self::$changeId;
        } else {
            self::$error = 'Для редактирования убедитесь, что отметили событие, которое необходимооткорректировать';
            Log::error('Event wasn\'t change because of fields "change_event" was empty');
            return self::$error;
        }
    }
    public static function findChangeContent( $changeId): array
    {
        $pdo = DbConnect::db_connect();
        foreach ($changeId as $a){
        $result = $pdo->prepare('select * from (select id_event, club_name, format_name, date, time, cost, comment from events JOIN clubs ON events.id_club = clubs.id_club JOIN formats ON events.id_format = formats.id_format) as foo where id_event = ?');
        $result->execute([$a]);
        $data = $result->fetchAll();
        self::$change_content[] = $data;
        }
        return self::$change_content;
    }
    public static function ContentForView(array $change_content):void
    {
        var_dump($change_content);
        echo '<br>';
        foreach($change_content as $t){
            foreach($t as $content){
            var_dump($content);
            self::$time = $content['time'];
            self::$date = $content['date'];
            self::$cost = $content['cost'];
            self::$format_name = $content['format_name'];
            self::$club_name = $content['club_name'];
            self::$comment = $content['comment'];
        }
        }
    }
    public static function ContentForBot(array $delete):void
    {
        foreach($delete as $content){
            self::$time = $content['time'];
            self::$date = $content['date'];
            self::$format_name = $content['format_name'];
            self::$club_name = $content['club_name'];
        }
    }
}