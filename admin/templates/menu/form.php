<?php
if ($_POST) {
    $item = array_merge($_POST, $_GET); // так нужно, чтобы взять id из _GET
}
else {
    $item = getId()? GetMenuItem(getId()) : [
        'id' => '',
        'name' => ''
    ];
}
?>
<div class="page-header">
    <?php if (getId()): ?>
        <h4>Редактирование меню</h4>
    <?php else: ?>
        <h4>Добавление нового меню</h4>
    <?php endif; ?>
</div>
<?php if (isset($errors) && $errors): ?>
    <div class="alert alert-danger" role="alert"><?= implode('<br/>', $errors) ?></div>
<?php endif; ?>
<?php if (isset($message) && $message): ?>
    <div class="alert alert-success" role="alert"><?= $message ?></div>
<?php endif; ?>
<form method="post" action="?section=menu&action=<?= $item['id']? 'update' : 'add' ?>&id=<?= $item['id'] ?>">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Название пункта меню"
               value="<?= $item['name'] ?>">
    </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
