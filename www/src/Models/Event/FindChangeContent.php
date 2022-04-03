<?php

namespace Otus\Models\Event;

use Otus\Log;
use Otus\Models\Connect\DbConnect;

class FindChangeContent extends FindContent
{
    public static $change_id;
    public static array $change_content = [];
    public static array $change_content_view = [];

    public static function findChangeID()
    {
        if (empty ($_POST['id_event']) and empty ($_POST['change'])) {
            return self::$change_id;
        } elseif (!empty ($_POST['id_event']) and !empty ($_POST['change'])) {
            if (count($_POST['id_event']) > 1) {
                Log::error('Event wasn\'t changed because of count id > 1');
                self::$error = 'Одновременно можно редактировать только одно событие';
                return self::$error;
            }
            self::$change_id = $_POST['id_event'];
            return self::$change_id;
        } elseif (empty ($_POST['id_event']) and !empty ($_POST['change'])) {
            self::$error = 'Для редактирования убедитесь, что отметили событие, которое необходимо откорректировать';
            Log::error('Event wasn\'t change because of fields "change_event" was empty');
            return self::$error;
        }
    }

    public static function findChangeContentDb($change_id): array
    {
        try {
            $pdo = DbConnect::dbConnect();
            foreach ($change_id as $id) {
                $result = $pdo->prepare('select * from (select id_event, club_name, format_name, date, time, cost, comment from events JOIN clubs ON events.id_club = clubs.id_club JOIN formats ON events.id_format = formats.id_format) as foo where id_event = ?');
                $result->execute([$id]);
                $data = $result->fetchAll();
                self::$change_content_view[] = $data;
            }

        } catch (\Throwable $exception) {
            echo 'Something was wrong. We will fix it soon';
            Log::warning('Couldn\'t find content to change!!!', ['id_event' => $id]);
        }
        return self::$change_content_view;
    }

    public static function contentForView(array $change_content_view): void
    {
        foreach ($change_content_view as $change) {
            foreach ($change as $content) {
                self::$change_id = $content['id_event'];
                self::$time = $content['time'];
                self::$date = $content['date'];
                self::$cost = $content['cost'];
                self::$format_name = $content['format_name'];
                self::$club_name = $content['club_name'];
                self::$comment = $content['comment'];
            }
        }
    }

    public static function findContent()
    {
        if (empty($_POST['add_change']) and empty($_POST['change']) and empty($_POST['delete']) and empty($_POST['add'])) {
            return false;
        }
        if (!empty($_POST['add']) or !empty($_POST['change']) or !empty($_POST['delete'])) {
            return false;
        }
        if (empty($_POST['date']) and empty($_POST['time']) and empty($_POST['cost']) and empty($_POST['comment']) and empty($_POST['club_name']) and empty($_POST['format_name']) and !empty($_POST['add_change'])) {
            self::$change_content = [];
            return self::$change_content;
        }
        if (!empty($_POST['date']) and !empty($_POST['time']) and !empty($_POST['cost']) and !empty($_POST['add_change'])) {
            if (!preg_match('/^\d+$/', $_POST['cost'])) {
                self::$error = 'Поле "Стоимость" должно содержать только цифры';
                Log::error('Event wasn\'t added because of fields "cost" must include just numeric');
                return self::$error;
            } else {
                self::$change_id = self::$change_content['id_event'] = $_POST['id_event'];
                self::$club_name = self::$change_content['club_name'] = $_POST['club_name'];
                self::$format_name = self::$change_content['format_name'] = $_POST['format_name'];
                self::$date = self::$change_content['date'] = $_POST['date'];
                self::$time = self::$change_content['time'] = $_POST['time'];
                self::$cost = self::$change_content['cost'] = $_POST['cost'];
            }
            if (empty($_POST['comment'])) {
                self::$change_content['comment'] = self::$comment;
                return self::$change_content;
            } else {
                if (!preg_match('/^[a-zA-Zа-яёА-ЯЁ0-9\s\+-_!@]+$/u', $_POST['comment'])) {
                    self::$error = 'Доболнительная информация содержит запрещенные символы';
                    Log::error('Event wasn\'t added because of fields "comment" musn\'t include forbidden symbols');
                    return self::$error;
                } else {
                    self::$comment = self::$change_content['comment'] = $_POST['comment'];
                    return self::$change_content;
                }
            }
        } else {
            Log::error('Event wasn\'t added because of fields are empty');
            self::$error = 'Необходимо заполнить все поля';
            return self::$error;
        }
    }

    public static function contentForBot(array $change_content): void
    {
        self::$change_id = $change_content['id_event'];
        self::$time = $change_content['time'];
        self::$date = $change_content['date'];
        self::$cost = $change_content['cost'];
        self::$format_name = $change_content['format_name'];
        self::$club_name = $change_content['club_name'];
        self::$comment = $change_content['comment'];
    }
}