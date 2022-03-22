<?php
namespace Otus\Controllers;

use Otus\Models\Event\FindAddContent;
use Otus\Models\Event\FindChangeContent;
use Otus\Models\Event\FindDeleteContent;
use Otus\Models\Event\Get;
use Otus\View;

class AdminController {
    public static $add_content;
    public static $delete_Id;
    public static $change_Id;
    public static function start():void
    {
        self::$add_content = FindAddContent::find_content();
        self::$delete_Id = FindDeleteContent::findDeleteID();
        self::$change_Id = FindChangeContent::findChangeID();
        if (self::$add_content){
            EventAddController::add_event();
        }elseif (self::$delete_Id){
            EventDeleteController::delete_event();
        }elseif (self::$change_Id){
            EventChangeController::change_event();
        }
        else{
            self::show_events();
        }



//        $add_content = FindAddContent::find_content();
//        $delete_Id = FindDeleteContent::findDeleteID();
//        if ($add_content and !FindAddContent::$error) {
//            Check::CheckAddContent(FindAddContent::$date, FindAddContent::$time);
//            if (Check::$error) {
//                View::$error = Check::$error;
//                self::show_events();
//            } else {
//                BotAddController::sendSchedule();
//                BotAddController::sendPoll();
//                Add::add_event($add_content);
//                self::show_events();
//            }
//        } elseif (FindAddContent::$error) {
//            View::$error = FindAddContent::$error;
//            self::show_events();
//        }
//        elseif ($delete_Id and !FindDeleteContent::$error){
//            $delete_content = FindDeleteContent::findDeleteContent($delete_Id);
//            foreach ($delete_content as $delete){
//                FindDeleteContent::ContentForBot($delete);
//                BotDeleteController::sendDelete();
//            }
//            Delete::delete($delete_Id);
//            self::show_events();
//        } elseif (FindDeleteContent::$error){
//            View::$error = FindDeleteContent::$error;
//            self::show_events();
//        }
//        else {
//            self::show_events();
//        }
    }
    public static function show_events():void
    {
        $content = Get::get_events();
        $view = new View("Добро пожаловать, {$_SESSION['name']}","Events", $content);
        $view->show_events();
    }
}

