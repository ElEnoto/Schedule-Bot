<?php

namespace Otus\Models\Authenticate;

use Otus\Log;
use Otus\Models\Connect\DbConnect;

class Authenticate
{
    public static string $error = '';
    public static function dbAuthenticate(string $username, string|int $password): ?int
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

    public static function userAuthenticate()
    {
        try {
            if (!empty($_GET['action']) && $_GET['action'] == 'auth' && empty($_SESSION['user_id'])) {
                $result = Authenticate::dbAuthenticate($_POST['username'], $_POST['password']);
                if (!$result) {
                    self::$error = "Невреное имя пользователя или пароль!";
                } else {
                    $_SESSION['user_id'] = $result;
                    $_SESSION['name'] = $_POST['username'];
                    Log::notice('Hello', ['user_id' => $result]);
                }
            }
            if (empty($_SESSION['user_id'])) {
                return false;
            } else {
                return $_SESSION['user_id'];
            }
        } catch (\Throwable $exception) {
            echo 'Something was wrong. We will fix it soon';
            Log::warning('We have a problem with Authenticate!!!');
        }
    }
}