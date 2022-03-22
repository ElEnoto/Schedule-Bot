<?php

namespace Otus\Controllers;

use Otus\Models\Event\Delete;
use Otus\Models\Event\FindDeleteContent;
use Otus\View;

class EventDeleteController
{
    public static function delete_event():void
    {
        if (!FindDeleteContent::$error){
            $delete_content = FindDeleteContent::findDeleteContent(AdminController::$delete_Id);
            foreach ($delete_content as $delete){
                FindDeleteContent::ContentForBot($delete);
                BotDeleteController::sendDelete();
            }
            Delete::delete(AdminController::$delete_Id);
            AdminController::show_events();
        } else {
            View::$error = FindDeleteContent::$error;
            AdminController::show_events();
        }
    }
}