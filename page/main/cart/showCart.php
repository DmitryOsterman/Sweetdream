<?php

if (GetCartId()) {
    $cart_id = GetCartId();
    $items = GetCartItemsList($cart_id);
    $total = 0;

} else {
    $errors = [];
    $errors[] = 'Непредвиденная ошибка';
    return $errors;
}
?>

<?php if (isset($errors) && $errors): ?>
    <div class="centerWarningBlock"><?= implode('<br/>', $errors) ?></div>
<?php endif; ?>
<?php if (isset($message) && $message): ?>
    <div class="centerSuccessBlock"><?= implode('<br/>', $message) ?></div>
<?php endif; ?>
<?php if (isset($btnOk) && $btnOk): ?>
    <div class='flowContainer'>
        <button class="submitButton center"
                onclick="location.href='?section=store&category_id=<?=
                GetProductItem(getId())['parent_id'] ?>'">
            Продолжить покупки
        </button>
    </div>

<?php endif;

if (CountCartItems(GetCartId()) == 0) {
    echo "<H2>Ваша корзина пуста</H2>";
    return false;
}
echo "<H2>Содержимое корзины</H2>";
echo "<div class='flowContainer'>";
foreach ($items as $item) {
    $product = GetProductItem($item['product_id']); // смотрим на этот товар из каталога

    ?>
    <div class='menuItem'>
        <?php if ($product['img_link']) {
            echo "<img src = " . ImgUrl() . $product['img_link'] . ">";
        } else {
            echo "<img alt = 'prepare' src = " . ImgUrl() . "no_img.png>";
        }
        ?>

        <a href="<?= $_SERVER['PHP_SELF'] ?>?section=store&id=<?= $product['id'] ?>">
            <?= $product['name'] ?>
        </a>

        <div class=''>В корзине: <?= $item['amount'] ?> шт.</div>
        <div class=''>По цене: <?= $product['price'] ?> руб.</div>
        <br>

        <div>
            <a class='CartButtonEdit'
               href="<?= $_SERVER['PHP_SELF'] ?>?section=cart&action=edit&id=<?= $item['id'] ?>">
                Edit
            </a>
            <a class='CartButtonDelete'
               href="<?= $_SERVER['PHP_SELF'] ?>?section=cart&action=delete&id=<?= $item['id'] ?>"
               onclick="return confirm('Вы уверены?');">
                Delete
            </a>
        </div>

    </div>
    <?php
    $total += $item['amount'] * GetProductItem($item['product_id'])['price'];
}
echo "</div>";
?>
    <h4>Итого: <?= $total ?> руб.</h4>
    <button type="submit" class="submitButton"
            onclick="return confirm('Вы уверены?');">
        Оформить заказ
    </button>

<?php
//}