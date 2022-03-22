<?php
namespace Otus\Models\Event;

use Otus\Models\Connect\DbConnect;


class Get
{
    public static function get_events():array
    {
            $pdo = DbConnect::db_connect();
            $result = $pdo->query('select * from (select id_event, club_name, format_name, date, time, cost, comment from events JOIN clubs ON events.id_club = clubs.id_club JOIN formats ON events.id_format = formats.id_format) as foo ORDER BY date');
            $result->execute();
            $events = $result->fetchAll();
            return $events;
    }
}
