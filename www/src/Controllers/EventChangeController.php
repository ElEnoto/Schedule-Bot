<?php

namespace Otus\Controllers;

use Otus\Models\Event\Change;
use Otus\Models\Event\Check;
use Otus\Models\Event\FindChangeContent;
use Otus\View;

class EventChangeController
{
    public static $id;

    public static function change_event(): void
    {
        if (!FindChangeContent::$error) {
            $change_content = FindChangeContent::findChangeContent(AdminController::$change_Id);
            FindChangeContent::ContentForView($change_content);
            AdminController::show_events();
        } else {
            View::$error = FindChangeContent::$error;
            AdminController::show_events();
        }

    }
    public static function add_change_event()
    {

        if (!FindChangeContent::$error){
//            Check::CheckChangeContent(FindChangeContent::$changeId, FindChangeContent::$club_name, FindChangeContent::$format_name, FindChangeContent::$date, FindChangeContent::$time, FindChangeContent::$cost, FindChangeContent::$comment);
//            if (Check::$error){
//                View::$error = Check::$error;
//                AdminController::show_events();
//            } else {
                Check::CheckAddContent(FindChangeContent::$date, FindChangeContent::$time);
                if (Check::$error) {
                    View::$error = Check::$error;
                    AdminController::show_events();
                } else {
                    var_dump(FindChangeContent::$changeId);
                    var_dump(self::$id);
                    Change::change_event(AdminController::$change_Id,AdminController::$change_content);
                    AdminController::show_events();
                }

        } else {
            View::$error = FindChangeContent::$error;
            AdminController::show_events();}
    }

}