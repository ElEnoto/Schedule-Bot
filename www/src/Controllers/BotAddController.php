<?php

namespace Otus\Controllers;

use Otus\Models\Event\FindAddContent;

class BotAddController
{
    public static function sendSchedule():void
    {
        if (FindAddContent::$comment){
            $answer = 'Мероприятие на ' . FindAddContent::$date . PHP_EOL . PHP_EOL .
                'Клуб: ' . FindAddContent::$club_name . PHP_EOL .
                'Формат: ' . FindAddContent::$format_name . PHP_EOL .
                'Начало турнира: ' . FindAddContent::$time . PHP_EOL .
                'Стоимость участия: ' . FindAddContent::$cost . ' рублей' . PHP_EOL .
                 PHP_EOL. FindAddContent::$comment;
        } else {
            $answer = 'Мероприятие на ' . FindAddContent::$date . PHP_EOL . PHP_EOL .
                'Клуб: ' . FindAddContent::$club_name . PHP_EOL .
                'Формат: ' . FindAddContent::$format_name . PHP_EOL .
                'Начало турнира: ' . FindAddContent::$time . PHP_EOL .
                'Стоимость участия: ' . FindAddContent::$cost . ' рублей';
        }

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
    public static function sendPoll():void
    {
        $question = 'Вы примите участие?' . PHP_EOL .
            FindAddContent::$club_name . ' ' . FindAddContent::$date . ' ' . FindAddContent::$time . ' ' . FindAddContent::$cost . 'р';
        $options = ['Иду', 'Не пойду', 'Посмотреть ответы'];
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