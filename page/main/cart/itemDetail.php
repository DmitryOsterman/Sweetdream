<?php
if (getId()) {
    $item = GetCartItem(getId());
    $product = GetProductItem($item['product_id']); // смотрим на этот товар из каталога
} else {
    $errors[] = 'Отсутствует id товара';
    return $errors;
};
?>

<?php if (isset($errors) && $errors): ?>
    <div class="centerWarningBlock"><?= implode('<br/>', $errors) ?></div>
<?php endif; ?>
<?php if (isset($message) && $message): ?>
    <div class="centerSuccessBlock"><?= $message ?></div>
<?php endif; ?>

<h4>Редактирование товара в корзине</h4>
<div class="goodsContainer">

    <div class="itemDetail">

        <div class="name">
            <p>Наименование:</p>
            <?= $product['name'] ?>
        </div>

        <?php if ($product['img_link']) {
            echo "<img src = " . ImgUrl() . $product['img_link'] . ">";
        } else {
            echo "<img alt = 'prepare' src = " . ImgUrl() . "no_img.png>";
        }?>

        <div class="blockFloat">

            <div class="price">
                <p>Цена:</p>
                <b><?= $product['price'] ?> руб.</b>
            </div>

            <div class="amount">
                <p>Доступно:</p>
                <b><?= $product['amount'] ?> шт.</b>
            </div>


            <div>
                <form method="post"
                      action="<?= $_SERVER['PHP_SELF'] ?>?section=cart&action=update&id=<?= $item['id'] ?>">

                    <div class="amountItems">
                        <label for="amountItems">Количество</label>
                        <input id="amountItems" type="number" name="amount"
                               min="0" max="<?= $product['amount'] ?>"
                               value="<?= $item['amount'] ?>">
                    </div>
                    <button class="addToCartButton" type="submit">Сохранить</button>
                </form>
            </div>

        </div>

        <div class="description">
            <p>Описание:</p>
            <p><?= $item['description'] ?></p>
        </div>

    </div>
</div>
