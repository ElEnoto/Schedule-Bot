<?php

namespace Otus\Controllers;

use Otus\Log;
use Otus\Models\Event\FindAddContent;
use Otus\Models\Event\FindChangeContent;
use Otus\Models\Event\FindDeleteContent;
use Otus\Models\Event\Get;
use Otus\View;

class AdminController
{
    public static $add_content;
    public static $change_content;
    public static $delete_Id;
    public static $change_Id;

    public static function start(): void
    {
        try {
            self::$add_content = FindAddContent::findAddContent();
            self::$change_content = FindChangeContent::FindChangeContent();
            self::$delete_Id = FindDeleteContent::findDeleteID();
            self::$change_Id = FindChangeContent::findChangeID();
            if (self::$add_content) {
                EventAddController::addEvent();
            } elseif (self::$delete_Id) {
                EventDeleteController::deleteEvent();
            } elseif (self::$change_Id) {
                EventChangeController::changeEvent();
            } elseif (self::$change_content) {
                EventChangeController::addChangeEvent();
            } else {
                self::showEvents();
            }
        } catch (\Throwable $exception) {
            echo 'Something was wrong. We will fix it soon';
            Log::warning('We have a problem with Admin!!!');
        }
    }

    public static function showEvents(): void
    {
        $content = Get::getEvents();
        $view = new View("Добро пожаловать, {$_SESSION['name']}", "Events", $content);
        $view->showEvents();
    }
}

