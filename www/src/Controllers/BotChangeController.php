<?php

namespace Otus\Controllers;

use Otus\Log;
use Otus\Models\Event\FindChangeContent;

class BotChangeController
{
    public const GAME = "\u{1F3B2}";
    public const ATTENTION = "\u{26A0}";
    public const YES = "\u{2705}";
    public const NO = "\u{274C}";
    public const TOMATO = "\u{1F345}";

    public static function sendChangeSchedule(): void
    {
        try {
            $answer = self::ATTENTION . '<b>Обращаем Ваше внимание. Произошли изменения!</b>' . self::ATTENTION . PHP_EOL .
                '<b>Мероприятие на </b>' . FindChangeContent::$date . self::GAME . PHP_EOL . PHP_EOL .
                '<b>Клуб: </b>' . FindChangeContent::$club_name . PHP_EOL .
                '<b>Формат: </b>' . FindChangeContent::$format_name . PHP_EOL .
                '<b>Начало турнира: </b>' . FindChangeContent::$time . PHP_EOL .
                '<b>Стоимость участия: </b>' . FindChangeContent::$cost . ' рублей' . PHP_EOL .
                PHP_EOL . FindChangeContent::$comment;
            $array = ['chat_id' => Config::CHAT_ID, 'text' => $answer, 'parse_mode' => 'HTML'];
            $ch = curl_init('https://api.telegram.org/bot' . Config::TOKEN . '/sendMessage');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $array);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
            Log::notice('Bot send changed schedule', ['date' => FindChangeContent::$date, 'time' => FindChangeContent::$time]);
        } catch (\Throwable $exception) {
            echo 'Something was wrong. We will fix it soon';
            Log::warning('Bot does not send changed schedule!!!', ['date' => FindChangeContent::$date, 'time' => FindChangeContent::$time]);
        }
    }

    public static function sendChangePoll(): void
    {
        try {
            $question = 'Вы примите участие?' . PHP_EOL .
                FindChangeContent::$club_name . ' ' . FindChangeContent::$date . ' ' . FindChangeContent::$time . ' ' . FindChangeContent::$cost . 'р';
            $options = [self::YES . ' Иду', self::NO . ' Не пойду', self::TOMATO];
            $array = ['chat_id' => Config::CHAT_ID, 'question' => $question, 'options' => json_encode($options)];
            $ch = curl_init('https://api.telegram.org/bot' . Config::TOKEN . '/sendPoll');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $array);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
            Log::notice('Bot sent changed poll', ['date' => FindChangeContent::$date, 'time' => FindChangeContent::$time]);
        } catch (\Throwable $exception) {
            echo 'Something was wrong. We will fix it soon';
            Log::warning('Bot did not send changed poll!!!', ['date' => FindChangeContent::$date, 'time' => FindChangeContent::$time]);
        }
    }
}