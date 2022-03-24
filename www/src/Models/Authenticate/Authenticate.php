<?php

namespace Otus\Models\Authenticate;

use Otus\Log;
use Otus\Models\Connect\DbConnect;

class Authenticate
{
    public static function authenticate($username, $password): ?int
    {
        try {
            $pdo = DbConnect::dbConnect();
            $result = $pdo->prepare('select id from users where username = ? and password = ?');
            $result->execute([$username, md5($password)]);
            if ($result->rowCount() == 0)
                return false;
            Log::notice('Authenticate user');
        } catch (\Throwable $exception) {
            echo 'Something was wrong. We will fix it soon';
            Log::warning('couldn\'t authenticate');
        }
        return $result->fetchAll()[0]['id'];
    }
}