<?php

use Otus\View;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
          integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <title>Добро пожаловать</title>
</head>
<body>
<?php if (View::$error) { ?>
    <h2><?php echo View::$error; ?></h2><?php
} ?>

<div style="padding: 15px">
    <h2>Войдите в систему!</h2><br>
    <form action="/?action=auth" method="post" enctype="multipart/form-data" class="w-25">
        <div class="form-group">
            <label for="username">Имя пользователя:</label>
            <input type="text" class="form-control" name="username">
        </div>
        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" class="form-control" name="password">
        </div>
        <input type="submit" class="btn btn-primary" value="Войти в систему">
    </form>
</div>
</body>
</html>
