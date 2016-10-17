<?php
if (getId()) {
    $item = GetCartItem(getId());
    $product = GetProductItem($item['product_id']); // смотрим на этот товар из каталога
} else {
    $errors[] = 'Отсутствует id товара';
};
?>

<div class="page-header">
    <h4>Редактирование товара в корзине N<?= $item['cart_id'] ?></h4>
</div>
<?php if (isset($errors) && $errors): ?>
    <div class="alert alert-danger" role="alert"><?= implode('<br/>', $errors) ?></div>
<?php endif; ?>
<?php if (isset($message) && $message): ?>
    <div class="alert alert-success" role="alert"><?= $message ?></div>
<?php endif; ?>

<form method="post" action="?section=cart_items&action=update&id=<?= $item['id'] ?>">
    <input type="hidden" name="cart_id" value="<?=$item['cart_id']?>">
    <input type="hidden" name="product_id" value="<?=$item['product_id']?>">

    <!--      enctype='multipart/form-data'-->
    <div class="form-group col-xs-4">
        <label for="name">Название</label>
        <input type="text" class="form-control" id="name" name="name"
               disabled="disabled"
               value="<?= $product['name'] ?>">
    </div>
    <div class="form-group col-xs-2">
        <label for="price">Цена, руб</label>
        <input type="text" class="form-control" id="price" name="price"
               disabled="disabled"
               placeholder="Цена товара"
               value="<?= $product['price'] ?>">
    </div>
    <div class="form-group col-xs-2">
        <label for="amount">Количество</label>
        <input type="number" class="form-control" id="amount" name="amount"
               placeholder="Количество"
               value="<?= $item['amount'] ?>">
        <p>На складе = <?= $product['amount'] ?> шт. </p>
    </div>
    <div class="form-group">
        <label for="img">Картинка</label>
        <?php if ($product['img_link']): ?>
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <img class="img-thumbnail" width="250"
                         src="<?= ImgUrl() . $product['img_link'] ?>">
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
