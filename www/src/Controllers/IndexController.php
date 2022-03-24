<?php

namespace Otus\Controllers;

use Otus\Log;
use Otus\Models\Authenticate\Authenticate;
use Otus\View;

class IndexController
{
    public function action(): void
    {
        try {
            session_start();
            if (!empty($_GET['action']) && $_GET['action'] == 'auth' && empty($_SESSION['user_id'])) {
                $result = Authenticate::authenticate($_POST['username'], $_POST['password']);
                if (!$result) {
                    Log::error('Wrong username or password');
                    View::$error = "Невреное имя пользователя или пароль!";
                    View::authenticate();
                } else {
                    $_SESSION['user_id'] = $result;
                    $_SESSION['name'] = $_POST['username'];
                    Log::notice('Hello', ['user_id' => $result]);
                }
            }
            if (empty($_SESSION['user_id'])) {
                View::authenticate();
            } else {
                $controller = new AdminController();
                $controller->start();
            }
        } catch (\Throwable $exception) {
            echo 'Something was wrong. We will fix it soon';
            Log::warning('We have a problem with Index!!!');
        }
    }
}

