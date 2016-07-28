<?php
if ($_POST) {
    $item = array_merge($_POST, $_GET); // так нужно, чтобы взять id из _GET
}
else {
    $item = getId()? GetCatalogItem(getId()) : [
        'id' => '',
        'parent_id' => 0,
        'name' => ''
    ];
}
$root_items = GetCatalogList();
?>
<div class="page-header">
    <?php if (getId()): ?>
        <h4>Редактирование категории</h4>
    <?php else: ?>
        <h4>Добавление новой категории</h4>
    <?php endif; ?>
</div>
<?php if (isset($errors) && $errors): ?>
    <div class="alert alert-danger" role="alert"><?= implode('<br/>', $errors) ?></div>
<?php endif; ?>
<?php if (isset($message) && $message): ?>
    <div class="alert alert-success" role="alert"><?= $message ?></div>
<?php endif; ?>
<form method="post" action="?section=catalog&action=<?= $item['id']? 'update' : 'add' ?>&id=<?= $item['id'] ?>">
    <div class="form-group">
        <label for="parent_id">Родительский элемент</label>
        <select class="form-control" id="parent_id" name="parent_id">
            <option value="0">Верхний уровень</option>
            <?php foreach ($root_items as $p): ?>
                <option value="<?= $p['id'] ?>" <?= $item['parent_id'] == $p['id']? 'selected="selected"' : '' ?>>
                    <?= $p['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Название пункта меню"
               value="<?= $item['name'] ?>">
    </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
