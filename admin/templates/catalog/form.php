<?php
if ($_POST) {
    $item = array_merge($_POST, $_GET); // так нужно, чтобы взять id из _GET
} else {
    $item = getId() ? GetCatalogItem(getId()) : [
        'id' => '',
        'name' => ''
    ];
}
$root_items = GetCatalogList();
?>
<div class="page-header">
    <?php if (getId()): ?>
        <h4>Редактирование разделов каталога</h4>
    <?php else: ?>
        <h4>Добавление нового раздела каталога</h4>
    <?php endif; ?>
</div>
<?php if (isset($errors) && $errors): ?>
    <div class="alert alert-danger" role="alert"><?= implode('<br/>', $errors) ?></div>
<?php endif; ?>
<?php if (isset($message) && $message): ?>
    <div class="alert alert-success" role="alert"><?= $message ?></div>
<?php endif; ?>
<div class="col-xs-6">
    <form method="post" action="?section=catalog&action=<?= $item['id'] ? 'update' : 'add' ?>&id=<?= $item['id'] ?>">
        <div class="form-group">
            <label for="parent_id">Родительский элемент</label>
            <select class="form-control" id="parent_id" name="parent_id">
                <option value="0">Верхний уровень</option>
                <?php foreach ($root_items as $a) {
                    if ($a['parent_id'] == '0') {
                        echo "<option value=" . $a['id'] ;
                        if ($item['parent_id'] == $a['id']) {
                            echo ' selected="selected"';
                        } else {
                            echo "";
                        }
                        echo "> ".$a['name'] . " </option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name"
                   placeholder="Название раздела каталога"
                   value="<?= $item['name'] ?>">
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>
