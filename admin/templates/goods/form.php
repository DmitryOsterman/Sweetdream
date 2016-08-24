<?php
if ($_POST) {
    if (getId()) {
        $p = GetProductItem(getId()); // картинку можно взять только отсюда
    }
    else {
        $p = [];
    }
    $item = array_merge($p, $_POST, $_GET); // так нужно, чтобы взять id из _GET
    $item['parent_id'] = $item['category_id'];  // parent_id нужен, потому что у тебя поле из базы так называется, а мы передаем везде category_id
}
else {
    $item = getId()? GetProductItem(getId()) : [
        'id' => '',
        'parent_id' => 0, // номер категории из каталога
        'name' => '',
        'price' => '',
        'amount' => '',
        'img_link' => '',
    ];
}
?>
<div class="page-header">
    <?php if (getId()): ?>
        <h4>Редактирование товара</h4>
    <?php else: ?>
        <h4>Добавление нового товара</h4>
    <?php endif; ?>
</div>
<?php if (isset($errors) && $errors): ?>
    <div class="alert alert-danger" role="alert"><?= implode('<br/>', $errors) ?></div>
<?php endif; ?>
<?php if (isset($message) && $message): ?>
    <div class="alert alert-success" role="alert"><?= $message ?></div>
<?php endif; ?>
<form method="post" action="?section=goods&action=<?= $item['id']? 'update' : 'add' ?>&id=<?= $item['id'] ?>"
      enctype='multipart/form-data'>
    <div class="form-group">
        <label for="name">Название</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Название товара"
               value="<?= $item['name'] ?>">
    </div>
    <div class="form-group">
        <label for="category_id">Категория</label>
        <select class="form-control" id="category_id" name="category_id">
            <?php print_catalog(0, $item['parent_id']) ?>
        </select>
    </div>
    <div class="form-group col-xs-6">
        <label for="price">Цена, руб</label>
        <input type="text" class="form-control" id="price" name="price" placeholder="Цена товара"
               value="<?= $item['price'] ?>">
    </div>
    <div class="form-group col-xs-6">
        <label for="amount">Остаток на складе</label>
        <input type="number" class="form-control" id="amount" name="amount" placeholder="Остаток на складе"
               value="<?= $item['amount'] ?>">
    </div>
    <div class="form-group">
        <label for="img">Картинка</label>
        <?php if ($item['img_link']): ?>
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <img src="<?= ImgUrl() . $item['img_link'] ?>" class="img-thumbnail" width="250">
                    <p></p>
                    <p class="text-center">
                        <a href="?section=goods&action=delete-img&id=<?= $item['id'] ?>"
                           class="btn btn-danger"
                           onclick="return confirm('Вы уверены');">Удалить картинку
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <input type="file" class="form-control" id="img" name="img">
    </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
