<?php

namespace Otus\Controllers;

use Otus\Models\Event\FindAddContent;

class BotAddController
{
    public const GAME = "\u{1F3B2}";
    public const YES ="\u{2705}";
    public const NO ="\u{274C}";
    public const TOMATO ="\u{1F345}";
    public static function sendSchedule():void
    {
        $answer = '<b>Мероприятие на </b>' . FindAddContent::$date . self::GAME . PHP_EOL . PHP_EOL .
                '<b>Клуб: </b>' . FindAddContent::$club_name . PHP_EOL .
                '<b>Формат: </b>' . FindAddContent::$format_name . PHP_EOL .
                '<b>Начало турнира: </b>' . FindAddContent::$time . PHP_EOL .
                '<b>Стоимость участия: </b>' . FindAddContent::$cost . ' рублей' . PHP_EOL .
                 PHP_EOL. FindAddContent::$comment;

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
    public static function sendPoll():void
    {
        $question = 'Вы примите участие?' . PHP_EOL .
            FindAddContent::$club_name . ' ' . FindAddContent::$date . ' ' . FindAddContent::$time . ' ' . FindAddContent::$cost . 'р';
        $options = [self::YES .' Иду', self::NO .' Не пойду', self::TOMATO .' Посмотреть ответы'];
        $array = ['chat_id' => Config::CHAT_ID, 'question' => $question, 'options' => json_encode($options)];
        $ch = curl_init('https://api.telegram.org/bot' . Config::TOKEN . '/sendPoll');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $array);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
    }
}