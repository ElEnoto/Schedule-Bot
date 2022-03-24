<?php

namespace Otus\Controllers;

use Otus\Log;
use Otus\Models\Event\Change;
use Otus\Models\Event\Check;
use Otus\Models\Event\FindChangeContent;
use Otus\View;

class EventChangeController
{
    public static function changeEvent(): void
    {
        try {
            if (!FindChangeContent::$error) {
                $change_content = FindChangeContent::findChangeContentDb(AdminController::$change_Id);
                FindChangeContent::contentForView($change_content);
                AdminController::showEvents();
            } else {
                View::$error = FindChangeContent::$error;
                AdminController::showEvents();
            }
        } catch (\Throwable $exception) {
            echo 'Something was wrong. We will fix it soon';
            Log::warning('We have a problem with Change!!!');
        }
    }

    public static function addChangeEvent()
    {
        try {
            if (!FindChangeContent::$error) {
                Check::checkChangeContent(FindChangeContent::$change_id, FindChangeContent::$date, FindChangeContent::$time);
                if (Check::$error) {
                    View::$error = Check::$error;
                    AdminController::showEvents();
                } else {
                    FindChangeContent::contentForBot(AdminController::$change_content);
                    BotChangeController::sendChangeSchedule();
                    BotChangeController::sendChangePoll();
                    Change::changeEvent(AdminController::$change_content);
                    AdminController::showEvents();
                }
            } else {
                View::$error = FindChangeContent::$error;
                AdminController::showEvents();
            }
        } catch (\Throwable $exception) {
            echo 'Something was wrong. We will fix it soon';
            Log::warning('We have a problem with Add change!!!');
        }
    }
}