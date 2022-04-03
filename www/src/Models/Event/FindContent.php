<?php

namespace Otus\Models\Event;

abstract class FindContent
{
    public static string $error = '';
    public static string $club_name;
    public static string $format_name;
    public static string $date;
    public static string $time;
    public static int $cost;
    public static string $comment = 'Удачной игры!';

    public static function findContent()
    {

    }

}