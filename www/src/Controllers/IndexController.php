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
            Authenticate::userAuthenticate();
            if (Authenticate::$error) {
                Log::error('Wrong username or password');
                View::$error = Authenticate::userAuthenticate();
                View::authenticate();
            }
            if (!Authenticate::userAuthenticate()) {
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

