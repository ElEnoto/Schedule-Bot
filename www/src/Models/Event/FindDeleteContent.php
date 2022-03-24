<?php

namespace Otus\Models\Event;

use Otus\Log;
use Otus\Models\Connect\DbConnect;

class FindDeleteContent
{
    public static array $delete_id = [];
    public static array $delete_content = [];
    public static string $club_name;
    public static string $format_name;
    public static string $date;
    public static string $time;
    public static string $error = '';

    public static function findDeleteID()
    {
        if (empty ($_POST['id_event']) and empty ($_POST['delete'])) {
            return self::$delete_id;
        } elseif (!empty ($_POST['id_event']) and !empty ($_POST['delete'])) {
            self::$delete_id = $_POST['id_event'];
            return self::$delete_id;
        } elseif (empty ($_POST['id_event']) and !empty ($_POST['delete'])) {
            self::$error = 'Событие не удалено. Убедитесь, что отметили событие, которое хотите удалить';
            Log::error('Event wasn\'t deleted because of fields "delete_event" was empty');
            return self::$error;
        }
    }

    public static function findDeleteContent(array $id_delete_events): array
    {
        try {
            $pdo = DbConnect::dbConnect();
            foreach ($id_delete_events as $id_delete_event) {
                $result = $pdo->prepare('select * from (select id_event, club_name, format_name, date, time, cost, comment from events JOIN clubs ON events.id_club = clubs.id_club JOIN formats ON events.id_format = formats.id_format) as foo where id_event = ?');
                $result->execute([$id_delete_event]);
                $data = $result->fetchAll();
                self::$delete_content[] = $data;
            }
        } catch (\Throwable $exception) {
            echo 'Something was wrong. We will fix it soon';
            Log::warning('Couldn\'t find content to delete!!!', ['id_event' => $id_delete_event]);
        }
        return self::$delete_content;
    }

    public static function contentForBot(array $delete): void
    {
        foreach ($delete as $content) {
            self::$time = $content['time'];
            self::$date = $content['date'];
            self::$format_name = $content['format_name'];
            self::$club_name = $content['club_name'];
        }
    }
}