<?php
namespace Otus\Models\Authenticate;

use Otus\Log;
use Otus\Models\Connect\DbConnect;

class Authenticate
{
        public static function authenticate($username, $password): int
        {
            $pdo = DbConnect::db_connect();
            $result = $pdo->prepare('select id from users where username = ? and password = ?');
            $result->execute([$username, md5($password)]);
            if($result->rowCount() == 0)
                return false;
            Log::notice('Authenticate user');
            return $result->fetchAll()[0]['id'];
        }
}