<?php
$item = [
    'id' => '',
    'order_id' => '',
    'user_id' => '',
    'created' => '',
    'comment' => '',
];
?>
<div class="page-header">
    <h4>Добавление новой корзины</h4>
</div>
<?php if (isset($errors) && $errors): ?>
    <div class="alert alert-danger" role="alert"><?= implode('<br/>', $errors) ?></div>
<?php endif; ?>
<?php if (isset($message) && $message): ?>
    <div class="alert alert-success" role="alert"><?= $message ?></div>
<?php endif; ?>

<form method="post" action="?section=carts&action=add"
      enctype='multipart/form-data'>
    <div class="form-group">
        <label for="user_id">На кого оформлена корзина</label>
        <select class="form-control" id="user_id"
                name="user_id">
            <?php print_user() ?>
        </select>
    </div>
    <div class="form-group col-xs-6">
        <label for="created">Дата и время корзины</label>
        <input type="datetime" class="form-control" id="created"
               name="created" placeholder="Y-M-D H:M:S"
               value="<?php $today = date("Y-m-d H:i:s", time()); // (формат MySQL DATETIME)
               echo $today
               ?>">
    </div>

    <div class="form-group col-xs-6">
        <label for="comment">Комментарий</label>
        <input type="text" class="form-control" id="comment"
               name="comment" placeholder="Комментарий к корзине"
               value="<?= $item['comment'] ?>">
    </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
