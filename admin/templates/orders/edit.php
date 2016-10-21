<?php
$order_id = getId();
$items = GetOrderItemsList($order_id);

if (!isset($category_id)) {
    $categories = GetCatalogList();
    $product = current($categories);
    $category_id = $product['id'];
}
$products = GetProductList($category_id);
$total = 0;
?>
<div class="page-header">
    <h4>Список заказов</h4>
</div>
<?php if (isset($errors) && $errors): ?>
    <div class="alert alert-danger" role="alert"><?= implode('<br/>', $errors) ?></div>
<?php endif; ?>
<?php if (isset($message) && $message): ?>
    <div class="alert alert-success" role="alert"><?= $message ?></div>
<?php endif; ?>

<form class="container-fluid" role="form">
    <select onchange="location.href='?section=orders&action=edit&id='+this.value"
            class="form-control container-fluid">
        <?php print_order($order_id) ?>
    </select>
</form>
<p></p>
<button class="btn btn-primary"
        onclick="location.href='?section=orders&action=new'">
    Добавить
</button>
<button class="btn btn-default"
        onclick="location.href='?section=orders&action=edit&id=<?= $order_id ?>'">
    Редактировать
</button>
<a href="?section=orders&action=delete&id=<?= $order_id ?>"
   class="btn btn-danger"
   onclick="return confirm('Вы уверены?');">
    Удалить
</a>

<p></p>

<div class="col-xs-6">
    <table class="table table-striped">
        <h4 class="text-center">Товары в заказе</h4>
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
                    <?= $item['price'] ?>
                </td>

                <td class="text-center">
                    <button type="button" class="btn btn-default btn-sm"
                            onclick="location.href='?section=order_items&action=edit&id=<?= $item['id'] ?>'">
                        Edit
                    </button>
                    <a href="?section=order_items&action=delete&id=<?= $item['id'] ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Вы уверены?');">
                        Delete</a>
                </td>
            </tr>
        <?php
            $total += $item['amount'] * $item['price'];
        endforeach; ?>
    </table>
    <h4>Итого: <?= $total ?> руб.</h4>
</div>


<div class="col-xs-6">
    <h4 class="text-center">Доступные товары</h4>

    <form class="container-fluid" role="form">
        <select onchange="location.href='?section=orders&action=edit&id=<?= $order_id ?>&category_id='+this.value"
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
                    <form method="post" action="?section=order_items&action=add">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="hidden" name="order_id" value="<?= $order_id ?>">
                        <input type="hidden" name="price" value="<?= $product['price'] ?>">

                        <input type="number" name="amount" value="0" style="width: 88px">

                        <button type="submit" class="btn btn-primary btn-sm">
                            Add to order
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</div>
