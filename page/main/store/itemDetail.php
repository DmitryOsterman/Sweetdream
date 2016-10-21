<?php
if (getId()) {
    $item = GetProductItem(getId());
    $category_id = GetProductItem(getId())['parent_id'];
    $catalog = GetCatalogItem($category_id);
    $masterCatalog = GetCatalogItem($catalog['parent_id']);
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

<H4 class="CatalogItem">
    <a href="<?= $_SERVER['PHP_SELF'] ?>?section=store&action=show">Каталог</a>
</H4>
<span class="separator">»</span>

<?php if ($masterCatalog): ?>
    <H4 class="CatalogItem">
        <a href="<?= $_SERVER['PHP_SELF'] ?>?section=store&category_id=<?= $masterCatalog['id'] ?>">
            <?= $masterCatalog['name'] ?></a>
    </H4>
    <span class="separator">»</span>
<?php endif; ?>

<H4 class="CatalogItem">
    <a href="<?= $_SERVER['PHP_SELF'] ?>?section=store&category_id=<?= $catalog['id'] ?>">
        <?= $catalog['name'] ?>
    </a>
</H4>

<div class="goodsContainer">
    <div class="itemDetail">

        <div class="name">
            <p>Наименование:</p>
            <?= $item['name'] ?>
        </div>

        <?php if ($item['img_link']) {
            echo "<img src = " . ImgUrl() . $item['img_link'] . ">";
        } else {
            echo "<img alt = 'prepare' src = " . ImgUrl() . "no_img.png>";
        }?>

        <div class="blockFloat">

            <div class="price">
                <p>Цена:</p>
                <b><?= $item['price'] ?> руб.</b>
            </div>

            <div class="amount">
                <p>Доступно:</p>
                <b><?= $item['amount'] ?> шт.</b>
            </div>

            <div>
                <form method="post"
                      action="<?= $_SERVER['PHP_SELF'] ?>?section=store&action=addGoods&id=<?= $item['id'] ?>">

                    <div class="amountItems">
                        <label for="amountItems">Количество</label>
                        <input id="amountItems" type="number" name="amount"
                               min="0" max="<?= $item['amount'] ?>"
                               value="1">
                    </div>
                    <button class="addToCartButton" type="submit">В корзину</button>
                </form>
            </div>

        </div>

        <div class="description">
            <p>Описание:</p>
            <p><?= $item['description'] ?></p>
        </div>

    </div>
</div>
