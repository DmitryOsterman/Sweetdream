<?php
if (!isset($cart_id)) {
    $carts = GetCartList();
    $item = current($carts);
    $cart_id = $item['id'];
}
$items = GetCartItemsList($cart_id);
$total = 0;
?>

    <div class="page-header">
        <h4>Корзины</h4>
    </div>
<?php if (isset($errors) && $errors): ?>
    <div class="alert alert-danger" role="alert"><?= implode('<br/>', $errors) ?></div>
<?php endif; ?>
<?php if (isset($message) && $message): ?>
    <div class="alert alert-success" role="alert"><?= $message ?></div>
<?php endif; ?>

    <form class="container-fluid" role="form">
        <select onchange="location.href='?section=carts&cart_id='+this.value"
                class="form-control container-fluid"
                size="4">
            <?php print_cart($cart_id) ?>
        </select>
    </form>
    <p></p>
    <button class="btn btn-primary"
            onclick="location.href='?section=carts&action=new'">
        Добавить
    </button>
    <button class="btn btn-default"
            onclick="location.href='?section=carts&action=edit&id=<?= $cart_id ?>'">
        Редактировать
    </button>
    <a href="?section=carts&action=delete&id=<?= $cart_id ?>"
       class="btn btn-danger"
       onclick="return confirm('Вы уверены?');">
        Удалить
    </a>
<?php
if (count($items) > 0) :
    ?>
    <div class="col-xs-12">
        <table class="table table-striped">
            <h4>Товары в корзине</h4>
            <tr>
                <th>Id</th>
                <th>Id товара</th>
                <th>Название</th>
                <th>Картинка</th>
                <th>Количество</th>
                <th>Цена, руб</th>
            </tr>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td>
                        <?= $item['id'] ?>
                    </td>
                    <td>
                        <?= $item['product_id'] ?>
                    </td>
                    <td>
                        <?= GetProductItem($item['product_id'])['name'] ?>
                    </td>
                    <td>
                        <?php if (GetProductItem($item['product_id'])['img_link']): ?>
                            <img width="120"
                                 src="<?= ImgUrl() . GetProductItem($item['product_id'])['img_link'] ?>">
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= $item['amount'] ?>
                        <p>Осталось: <?= GetProductItem($item['product_id'])['amount'] ?> </p>
                    </td>
                    <td>
                        <?= GetProductItem($item['product_id'])['price'] ?>
                    </td>
                </tr>
                <?php
                $total += $item['amount'] * GetProductItem($item['product_id'])['price'];
            endforeach; ?>
        </table>

        <h4>Итого: <?= $total ?> руб.</h4>

        <form method="post" action="?section=carts&action=ordering&id=<?= $cart_id ?>">
            <button type="submit" class="btn btn-warning"
                    onclick="return confirm('Вы уверены?');">
                Заказать
            </button>
        </form>

    </div>
<?php
else :
    ?>
    <h4>Корзина не содержит товаров</h4>
<?php
endif
?>