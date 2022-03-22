<?php

namespace Otus\Models\Event;

use Otus\Log;
use Otus\Models\Connect\DbConnect;

class FindDeleteContent
{
    public static array $deleteId = [];
    public static array $delete_content = [];
    public static string $club_name;
    public static string $format_name;
    public static string $date;
    public static string $time;
    public static string $error = '';
    public static function findDeleteID()
    {
        if (empty ($_POST['id_event']) and empty ($_POST['delete'])){
            return self::$deleteId;
        }
        if (!empty ($_POST['id_event']) and !empty ($_POST['delete'])) {
            self::$deleteId = $_POST['id_event'];
            return self::$deleteId;
        }
        if (empty ($_POST['id_event']) and !empty ($_POST['delete'])) {
            self::$error = 'Событие не удалено. Убедитесь, что отметили событие, которое хотите удалить';
            Log::error('Event wasn\'t deleted because of fields "delete_event" was empty');
            return self::$error;
        }
    }
    public static function findDeleteContent(array $deleteId): array
    {
        $pdo = DbConnect::db_connect();
            foreach($deleteId as $idEvent) {
                $result = $pdo->prepare('select * from (select id_event, club_name, format_name, date, time, cost, comment from events JOIN clubs ON events.id_club = clubs.id_club JOIN formats ON events.id_format = formats.id_format) as foo where id_event = ?');
                $result->execute([$idEvent]);
                $data = $result->fetchAll();
                self::$delete_content[] = $data;
            }
        return self::$delete_content;
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