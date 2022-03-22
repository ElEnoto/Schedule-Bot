<?php

namespace Otus\Controllers;

use Otus\Models\Event\FindDeleteContent;

class BotDeleteController
{
    public const GAME = "\u{2757}";

    public static function sendDelete():void
    {
        $answer = "<b>Было отменено мероприятие!!!</b>" . self::GAME. PHP_EOL . PHP_EOL .
                    '<b>Дата: </b>' . FindDeleteContent::$date . PHP_EOL .
                    '<b>Клуб: </b>' . FindDeleteContent::$club_name . PHP_EOL .
                    '<b>Формат: </b>' . FindDeleteContent::$format_name . PHP_EOL .
                    '<b>Начало турнира: </b>' . FindDeleteContent::$time . PHP_EOL;
        $array = ['chat_id' => Config::CHAT_ID, 'text' => $answer, 'parse_mode' => 'HTML'];
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