<?php
namespace Otus\Models\Event;

use Otus\Log;

class FindAddContent
{
    public static array $add_content = [];
    public static string $error = '';
    public static string $club_name;
    public static string $format_name;
    public static string $date;
    public static string $time;
    public static int $cost;
    public static string $comment = 'Удачной игры!';
    public static function findAddContent():bool|array|string
    {
        if (!empty($_POST['add_change']) or !empty($_POST['change']) or !empty($_POST['delete'])){
            return false;
        }
        if (empty($_POST['date']) and empty($_POST['time']) and empty($_POST['cost']) and empty($_POST['comment']) and empty($_POST['club_name']) and empty($_POST['format_name']) and !empty($_POST['add'])){
            return self::$add_content;
        }
        if (!empty($_POST['date']) and !empty($_POST['time']) and !empty($_POST['cost']) and !empty($_POST['add'])) {
            if (!preg_match('/^\d+$/', $_POST['cost'])){
                self::$error = 'Поле "Стоимость" должно содержать только цифры';
                Log::error('Event wasn\'t added because of fields "cost" must include just numeric');
                return self::$error;
            } else {
                self::$club_name = self::$add_content['club_name'] = $_POST['club_name'];
                self::$format_name = self::$add_content['format_name'] = $_POST['format_name'];
                self::$date = self::$add_content['date'] = $_POST['date'];
                self::$time = self::$add_content['time'] = $_POST['time'];
                self::$cost = self::$add_content['cost'] = $_POST['cost'];
            }
            if (empty($_POST['comment'])) {
                self::$add_content['comment'] = self::$comment;
                return self::$add_content;
            } else {
                if (!preg_match('/^[a-zA-Zа-яёА-ЯЁ0-9\s\+-_@]+$/u', $_POST['comment'])) {
                    self::$error = 'Доболнительная информация содержит запрещенные символы';
                    Log::error('Event wasn\'t added because of fields "comment" musn\'t include forbidden symbols');
                    return self::$error;
                } else {
                    self::$comment = self::$add_content['comment'] = $_POST['comment'];
                    return self::$add_content;
                }
            }
        }
        else {
            Log::error('Event wasn\'t added because of fields are empty');
            self::$error = 'Необходимо заполнить все поля';
            return self::$error;
        }
    }
}
