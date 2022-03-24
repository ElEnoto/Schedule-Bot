<?php
namespace Otus\Models\Connect;

use Otus\Log;
use PDO;

class DbConnect
{
    public static function dbConnect()
    {
        try {
            return new PDO('pgsql:host=postgresql;dbname=otus','postgres','otus',[
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (\Throwable $exception){
            echo 'Something was wrong. We will fix it soon';
            Log::warning('couldn\'t connect to Db');
        }
    }
}