<?php

namespace Otus\Controllers;

use Otus\Models\Event\Add;
use Otus\Models\Event\Check;
use Otus\Models\Event\FindAddContent;
use Otus\View;

class EventAddController
{
    public static function add_event(): void
    {
        if (!FindAddContent::$error) {
            Check::CheckAddContent(FindAddContent::$date, FindAddContent::$time);
            if (Check::$error) {
                View::$error = Check::$error;
                AdminController::show_events();
            } else {
                BotAddController::sendSchedule();
                BotAddController::sendPoll();
                Add::add_event(AdminController::$add_content);
                AdminController::show_events();
            }
        } else{
        View::$error = FindAddContent::$error;
        AdminController::show_events();
        }
    }
}