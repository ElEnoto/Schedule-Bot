<?php

namespace Otus\Models\Event;

use Otus\Log;
use Otus\Models\Connect\DbConnect;

class Delete
{
    public static function delete(array $delete_id): void
    {
        try {
            $pdo = DbConnect::dbConnect();
            foreach ($delete_id as $id_event) {
                $result = $pdo->prepare('delete from events where id_event = ?');
                $result->execute([$id_event]);
                Log::notice('Event was deleted', ['id_event' => $id_event]);
            }
        } catch (\Throwable $exception) {
            echo 'Something was wrong. We will fix it soon';
            Log::warning('Event wasn\'t deleted!!!', ['id_event' => $id_event]);
        }
    }
}