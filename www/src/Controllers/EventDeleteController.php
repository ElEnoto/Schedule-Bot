<?php

namespace Otus\Controllers;

use Otus\Log;
use Otus\Models\Event\Delete;
use Otus\Models\Event\FindDeleteContent;
use Otus\View;

class EventDeleteController
{
    public static function deleteEvent(): void
    {
        try {
            if (!FindDeleteContent::$error) {
                $delete_content = FindDeleteContent::findDeleteContent(AdminController::$delete_Id);
                foreach ($delete_content as $delete) {
                    FindDeleteContent::contentForBot($delete);
                    BotDeleteController::sendDelete();
                }
                Delete::delete(AdminController::$delete_Id);
                AdminController::showEvents();
            } else {
                View::$error = FindDeleteContent::$error;
                AdminController::showEvents();
            }
        } catch (\Throwable $exception) {
            echo 'Something was wrong. We will fix it soon';
            Log::warning('We have a problem with Delete!!!');
        }
    }
}