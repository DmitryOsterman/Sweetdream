<?php
$item = GetProductItem(getId());
$category_id = GetProductItem(getId())['parent_id'];
?>

<h4><?= GetCatalogItem(GetCatalogItem($category_id)['parent_id'])['name'] ?> /
    <?= GetCatalogItem($category_id)['name'] ?></h4>

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
                      action="<?= $_SERVER['REQUEST_URI'] ?>&action=addGoods">

                    <!--  проверить! кол-во  addToCart -->

                    <div class="amountItems">
                        <label for="amountItems">Количество</label>
                        <input id="amountItems" type="number" name="amount" value="1">
                    </div>
                    <button class="addToCart" type="submit">В корзину</button>
                </form>
            </div>

        </div>

        <div class="description">
            <p>Описание:</p>

            <p><?= $item['description'] ?></p>
        </div>

    </div>
</div>
