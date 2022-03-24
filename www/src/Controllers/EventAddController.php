<?php

namespace Otus\Controllers;

use Otus\Log;
use Otus\Models\Event\Add;
use Otus\Models\Event\Check;
use Otus\Models\Event\FindAddContent;
use Otus\View;

class EventAddController
{
    public static function addEvent(): void
    {
        try {
            if (!FindAddContent::$error) {
                Check::checkAddContent(FindAddContent::$date, FindAddContent::$time);
                if (Check::$error) {
                    View::$error = Check::$error;
                    AdminController::showEvents();
                } else {
                    BotAddController::sendSchedule();
                    BotAddController::sendPoll();
                    Add::addEvent(AdminController::$add_content);
                    AdminController::showEvents();
                }
            } else {
                View::$error = FindAddContent::$error;
                AdminController::showEvents();
            }
        } catch (\Throwable $exception) {
            echo 'Something was wrong. We will fix it soon';
            Log::warning('We have a problem with Add!!!');
        }
    }
}