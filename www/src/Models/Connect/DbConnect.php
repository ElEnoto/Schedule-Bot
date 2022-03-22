<?php
namespace Otus\Models\Connect;

use PDO;

class DbConnect
{
    public static function db_connect()
    {
        try {
            return new PDO('pgsql:host=postgresql;dbname=otus','postgres','otus',[
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (\Throwable $exception){
            echo 'Something was wrong. We will fix it soon';
        }
    }
}