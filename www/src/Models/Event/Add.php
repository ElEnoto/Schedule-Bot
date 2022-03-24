<?php

namespace Otus\Models\Event;

use Otus\Log;
use Otus\Models\Connect\DbConnect;

class Add
{
    public static function addEvent(array $add_content): void
    {
        try {
            $pdo = DbConnect::dbConnect();
            $club_name = $add_content['club_name'];
            $format_name = $add_content['format_name'];
            $date = $add_content['date'];
            $time = $add_content['time'];
            $cost = $add_content['cost'];
            $comment = $add_content['comment'];
            $result = $pdo->prepare("insert into events (id_club, id_format, date, time, cost, comment) values ((select id_club from clubs where club_name like ?), (select id_format from formats where format_name like ?), ?, ?, ?, ?)");
            $result->execute([$club_name, $format_name, $date, $time, $cost, $comment]);
            Log::notice('Event was added', ['date' => $date, 'time' => $time]);
        } catch (\Throwable $exception) {
            echo 'Something was wrong. We will fix it soon';
            Log::warning('Event wasn\'t added!!!', ['date' => $date, 'time' => $time]);
        }
    }
}
