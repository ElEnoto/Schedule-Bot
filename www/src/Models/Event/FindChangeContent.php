<?php

namespace Otus\Models\Event;

use Otus\Log;
use Otus\Models\Connect\DbConnect;

class FindChangeContent
{
    public static string $club_name;
    public static string $format_name;
    public static string $date;
    public static string $time;
    public static string $cost;
    public static string $comment;
    public static string $error = '';
    public static $changeId;
    public static array $change_content = [];
    public static array $change_content_view = [];
    public static function findChangeID()
    {
        if (empty ($_POST['id_event']) and empty ($_POST['change'])){
            return self::$changeId;
        }elseif (!empty ($_POST['id_event']) and !empty ($_POST['change'])) {
            var_dump($_POST);
            echo count($_POST['id_event']);
            if(count($_POST['id_event']) > 1){
                self::$error = 'Одновременно можно редактировать только одно событие';
                return self::$error;
            }
            self::$changeId = $_POST['id_event'];
            return self::$changeId;
        } elseif(empty ($_POST['id_event']) and !empty ($_POST['change'])) {
            self::$error = 'Для редактирования убедитесь, что отметили событие, которое необходимооткорректировать';
            Log::error('Event wasn\'t change because of fields "change_event" was empty');
            return self::$error;
        }
    }
    public static function findChangeContent( $changeId): array
    {
        $pdo = DbConnect::db_connect();
        foreach ($changeId as $a){
        $result = $pdo->prepare('select * from (select id_event, club_name, format_name, date, time, cost, comment from events JOIN clubs ON events.id_club = clubs.id_club JOIN formats ON events.id_format = formats.id_format) as foo where id_event = ?');
        $result->execute([$a]);
        $data = $result->fetchAll();
        self::$change_content_view[] = $data;
        }
        return self::$change_content_view;
    }
    public static function ContentForView(array $change_content_view):void
    {
        var_dump($change_content_view);
        echo '<br>';
        foreach($change_content_view as $change){
            foreach($change as $content){
            var_dump($content);
            self::$changeId = $content['id_event'];
            self::$time = $content['time'];
            self::$date = $content['date'];
            self::$cost = $content['cost'];
            self::$format_name = $content['format_name'];
            self::$club_name = $content['club_name'];
            self::$comment = $content['comment'];
        }
        }
    }
    public static function change_content(){
        if (!empty($_POST['add']) or !empty($_POST['change']) or !empty($_POST['delete'])){
            return false;
        }
        if (empty($_POST['date']) and empty($_POST['time']) and empty($_POST['cost']) and empty($_POST['comment']) and empty($_POST['club_name']) and empty($_POST['format_name']) and !empty($_POST['add_change'])){
            self::$change_content = [];
            return self::$change_content;
        }
        if (!empty($_POST['date']) and !empty($_POST['time']) and !empty($_POST['cost']) and !empty($_POST['add_change'])) {
            if (!preg_match('/^\d+$/', $_POST['cost'])){
                self::$error = 'Поле "Стоимость" должно содержать только цифры';
                Log::error('Event wasn\'t added because of fields "cost" must include just numeric');
                return self::$error;
            } else {
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
                if (!preg_match('/^[a-zA-Zа-яёА-ЯЁ0-9\s\+-_@]+$/u', $_POST['comment'])) {
                    self::$error = 'Доболнительная информация содержит запрещенные символы';
                    Log::error('Event wasn\'t added because of fields "comment" musn\'t include forbidden symbols');
                    return self::$error;
                } else {
                    self::$comment = self::$change_content['comment'] = $_POST['comment'];
                    return self::$change_content;
                }
            }
        }
        else {
            Log::error('Event wasn\'t added because of fields are empty');
            self::$error = 'Необходимо заполнить все поля';
            return self::$error;
        }

    }

    public static function ContentForBot(array $delete):void
    {
        foreach($delete as $content){
            self::$time = $content['time'];
            self::$date = $content['date'];
            self::$format_name = $content['format_name'];
            self::$club_name = $content['club_name'];
        }
    }
}