<?php
$cart_id = getId();
$items = GetCartItemsList($cart_id);

if (!isset($category_id)) {
    $categories = GetCatalogList();
    $product = current($categories);
    $category_id = $product['id'];
}
$products = GetProductList($category_id);
$total = 0;
?>
<div class="page-header">
    <h4>Список корзин</h4>
</div>
<?php if (isset($errors) && $errors): ?>
    <div class="alert alert-danger" role="alert"><?= implode('<br/>', $errors) ?></div>
<?php endif; ?>
<?php if (isset($message) && $message): ?>
    <div class="alert alert-success" role="alert"><?= $message ?></div>
<?php endif; ?>

<form class="container-fluid" role="form">
    <select onchange="location.href='?section=carts&action=edit&id='+this.value"
            class="form-control container-fluid">
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

<p></p>

<div class="col-xs-6">
    <table class="table table-striped">
        <h4 class="text-center">Товары в корзине</h4>
        <tr>
            <th>Id</th>
            <th>Id тов.</th>
            <th>Название</th>
            <th>Картинка</th>
            <th>Кол-во</th>
            <th>Цена,р./ед</th>
            <th>Управление</th>
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
                        <img src="<?= ImgUrl() . GetProductItem($item['product_id'])['img_link'] ?>" width="60">
                    <?php endif; ?>
                </td>
                <td>
                    <?= $item['amount'] ?>
                </td>
                <td>
                    <?= GetProductItem($item['product_id'])['price'] ?>
                </td>

                <td class="text-center">
                    <button type="button" class="btn btn-default btn-sm"
                            onclick="location.href='?section=cart_items&action=edit&id=<?= $item['id'] ?>'">
                        Edit
                    </button>
                    <a href="?section=cart_items&action=delete&id=<?= $item['id'] ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Вы уверены?');">
                        Delete</a>
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

<div class="col-xs-6">
    <h4 class="text-center">Доступные товары</h4>

    <form class="container-fluid" role="form">
        <select onchange="location.href='?section=carts&action=edit&id=<?= $cart_id ?>&category_id='+this.value"
                class="form-control container-fluid">
            <?php print_catalog(0, $category_id) ?>
        </select>
    </form>
    <p></p>

    <table class="table table-striped">
        <tr>
            <th>Название</th>
            <th>Цена,р./ед</th>
            <th>Остаток</th>
            <th>Картинка</th>
            <th>Управление</th>
        </tr>
        <?php foreach ($products as $product): ?>
            <tr>
                <td>
                    <?= $product['name'] ?>
                </td>
                <td>
                    <?= $product['price'] ?>
                </td>
                <td>
                    <?= $product['amount'] ?>
                </td>
                <td>
                    <?php if ($product['img_link']): ?>
                        <img src="<?= ImgUrl() . $product['img_link'] ?>" width="60">
                    <?php endif; ?>
                </td>
                <td class="text-right">
                    <form method="post" action="?section=carts&action=addGoods">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="hidden" name="cart_id" value="<?= $cart_id ?>">
                        <input type="number" name="amount" value="0" style="width: 80px">

                        <button type="submit" class="btn btn-primary btn-sm">
                            Add to cart
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>