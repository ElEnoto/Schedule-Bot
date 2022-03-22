<?php
use Otus\View;
use Otus\Models\Event\FindChangeContent;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <title><?php echo $this->title?></title>
</head>

<body>
<div class="p-3">
<h2><?php echo $this->name ?></h2>
<?php if (View::$error){?>
    <h2><?php echo View::$error;?></h2><?php
}?>
</div>
<div class="p-3">
<form action="/?action=download_event" method="post" enctype="multipart/form-data" class="w-25">
    <div class="form-group">
        <label for="club_name">Название клуба</label>
        <select class="form-control" id="club_name" name="club_name">
            <option>Портал</option>
            <option>Убежище</option>
            <option>Единорог</option>
            <option>Лига</option>
        </select>
    </div>
    <div class="form-group">
        <label for="format_name">Формат</label>
        <select class="form-control" id="format_name" name="format_name">
            <option>Standard</option>
            <option>Brawl</option>
        </select>
    </div>
    <div class="form-group">
        <label for="date">Дата</label>
        <input type="date" class="form-control" id="date" name="date" min="<?php $date = new \DateTime('Monday next week');
        echo $date->format('Y-m-d'); ?>" max="<?php $date = new \DateTime('Sunday next week');
        echo $date->format('Y-m-d'); ?>">
    </div>
    <div class="form-group">
        <label for="time">Время</label>
        <input type="time" class="form-control" id="time" name="time"  <?php if (FindChangeContent::$change_content) {
            ?> value="<?php echo FindChangeContent::$time ?>"  <?php
        } ?> >
    </div>
    <div class="form-group">
        <label for="cost">Стоимость</label>
        <input type="text" class="form-control" id="cost" name="cost" placeholder="в рублях" <?php if (FindChangeContent::$change_content) {
            ?> value="<?php echo FindChangeContent::$cost ?>"  <?php
        } ?>>
    </div>
    <div class="form-group">
        <label for="comment">Дополнительная информация</label>
        <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="Удачной игры!"></textarea>
    </div>
    <input type="submit" class="btn btn-primary" value="Отправить расписание">
</form>

<form action="/?action=delete_event" method="post" enctype="multipart/form-data" class="mt-5">
    <table class="table table-hover">
        <thead>
        <tr class="text-center">
            <th scope="col">Дата</th>
            <th scope="col">Время</th>
            <th scope="col">Название клуба</th>
            <th scope="col">Формат</th>
            <th scope="col">Стоимость в рублях</th>
            <th scope="col">Дополнительная информация</th>
            <th scope="col">Удалить/Редактировать событие</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($this->content as $item) { ?>
        <tr class="text-center">
            <th scope="col"><?= $item['date'] ?></th>
            <td><?= $item['time'] ?></td>
            <td><?= $item['club_name'] ?></td>
            <td><?= $item['format_name'] ?></td>
            <td><?= $item['cost'] ?></td>
            <td><?= $item['comment'] ?></td>
            <td>
                <input type="checkbox" class="form-check-input" name="id_event[]" value="<?= $item['id_event'] ?>">
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    <input type="submit" class="btn btn-danger" name="delete"  value="Удалить">
    <input type="submit" class="btn btn-warning" name="change"  value="Редактировать">
</form>


</body>
</html>
