<?php

namespace Otus\Controllers;

use Otus\Models\Event\Add;
use Otus\Models\Event\Check;
use Otus\Models\Event\FindAddContent;
use Otus\Models\Event\FindChangeContent;
use Otus\View;

class EventChangeController
{
    public static function change_event(): void
    {
        if (!FindChangeContent::$error) {
            $change_content = FindChangeContent::findChangeContent(AdminController::$change_Id);
            FindChangeContent::ContentForView($change_content);
            AdminController::show_events();
        }

    }



//
//        if (!FindChangeContent::$error) {
//            Check::CheckAddContent(FindAddContent::$date, FindAddContent::$time);
//            if (Check::$error) {
//                View::$error = Check::$error;
//                AdminController::show_events();
//            } else {
//                BotAddController::sendSchedule();
//                BotAddController::sendPoll();
//                Add::add_event(AdminController::$add_content);
//                AdminController::show_events();
//            }
//        } else{
//            View::$error = FindAddContent::$error;
//            AdminController::show_events();
//        }
//    }
}