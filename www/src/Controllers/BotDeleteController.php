<?php

namespace Otus\Controllers;

use Otus\Models\Event\FindDeleteContent;

class BotDeleteController
{
    public static function sendDelete():void
    {
        $answer = 'Было отменено мероприятие!!!'. PHP_EOL . PHP_EOL .
                    'Дата: ' . FindDeleteContent::$date . PHP_EOL .
                    'Клуб: ' . FindDeleteContent::$club_name . PHP_EOL .
                    'Формат: ' . FindDeleteContent::$format_name . PHP_EOL .
                    'Начало турнира: ' . FindDeleteContent::$time . PHP_EOL;
        $array = ['chat_id' => Config::CHAT_ID, 'text' => $answer];
        $ch = curl_init('https://api.telegram.org/bot' . Config::TOKEN . '/sendMessage');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $array);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
    }
}