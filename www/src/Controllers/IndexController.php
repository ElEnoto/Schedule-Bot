<?php
namespace Otus\Controllers;
use Otus\Models\Authenticate\Authenticate;
use Otus\View;

class IndexController {
    public function action():void
    {
        session_start();
        if (!empty($_GET['action']) && $_GET['action'] == 'auth' && empty($_SESSION['user_id'])) {
            $result = Authenticate::authenticate($_POST['username'], $_POST['password']);
            if (!$result) {
                View::$error = "Невреное имя пользователя или пароль!";
                View::authenticate();
            } else {
                $_SESSION['user_id'] = $result;
                $_SESSION['name'] = $_POST['username'];
            }
        }
        if (empty($_SESSION['user_id'])) {
        View::authenticate();
        }
        else {
            $controller = new AdminController();
            $controller->start();
        }
    }
}

