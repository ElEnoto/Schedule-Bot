<?php

namespace Otus\Models\Event;

use Otus\Log;
use Otus\Models\Connect\DbConnect;

class Change
{
    public static function changeEvent(array $change_content): void
    {
        try {
            $pdo = DbConnect::dbConnect();
            $id = $change_content['id_event'];
            $club_name = $change_content['club_name'];
            $format_name = $change_content['format_name'];
            $date = $change_content['date'];
            $time = $change_content['time'];
            $cost = $change_content['cost'];
            $comment = $change_content['comment'];
            $result = $pdo->prepare("update events set id_club = (select id_club from clubs where club_name like ?), id_format = (select id_format from formats where format_name like ?), date = ?, time = ?, cost = ?, comment = ? where id_event = ?");
            $result->execute([$club_name, $format_name, $date, $time, $cost, $comment, $id]);
            Log::notice('Event was changed', ['date' => $date, 'time' => $time]);
        } catch (\Throwable $exception) {
            echo 'Something was wrong. We will fix it soon';
            Log::warning('Event wasn\'t changed!!!');
        }
    }
}