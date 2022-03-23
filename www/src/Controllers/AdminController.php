<?php
namespace Otus\Controllers;

use Otus\Models\Event\FindAddContent;
use Otus\Models\Event\FindChangeContent;
use Otus\Models\Event\FindDeleteContent;
use Otus\Models\Event\Get;
use Otus\View;

class AdminController {
    public static $add_content;
    public static $change_content;
    public static $delete_Id;
    public static $change_Id;
    public static function start():void
    {
        self::$add_content = FindAddContent::findAddContent();
        self::$change_content = FindChangeContent::change_content();
        self::$delete_Id = FindDeleteContent::findDeleteID();
        self::$change_Id = FindChangeContent::findChangeID();
        if (self::$add_content){
            EventAddController::add_event();
        }elseif (self::$delete_Id){
            EventDeleteController::delete_event();
        }elseif (self::$change_Id){
            EventChangeController::change_event();
        }elseif (self::$change_content){
            EventChangeController::add_change_event();
        }
        else{
            self::show_events();
        }

    }
    public static function show_events():void
    {
        $content = Get::get_events();
        $view = new View("Добро пожаловать, {$_SESSION['name']}","Events", $content);
        $view->show_events();
    }
}

