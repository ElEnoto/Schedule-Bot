<?php

namespace Otus\Models\Event;

use Otus\Models\Connect\DbConnect;

class Delete
{
    public static function delete(array $deleteId):void
    {
        $pdo = DbConnect::db_connect();
        foreach($deleteId as $idEvent) {
            $result = $pdo->prepare('delete from events where id_event = ?');
            $result->execute([$idEvent]);
        }
    }
}