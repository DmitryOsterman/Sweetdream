<?php

$item = GetProductItem(getId());
$category_id = getCategory_id();

echo "<div class='centerBlock'>";
echo "<h4>" . GetCatalogItem(GetCatalogItem($category_id)['parent_id'])['name'];
echo " / " . GetCatalogItem($category_id)['name'] . "</h4>";
?>
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
                }
                ?>

                <div class="blockFloat">

                    <div class="price">
                        <p>Цена:</p>
                        <b><?= $item['price'] ?> руб.</b>
                    </div>

                    <div class="amount">
                        <p>Доступно:</p>
                        <b><?= $item['amount'] ?> шт.</b>
                    </div>

                    <div class="addToCart">
                        <a href="<?= $_SERVER['REQUEST_URI']
                        ?>&order=<?= $item['id'] ?>">
                            В корзину
                        </a>
                    </div>
                </div>

                <div class="description">
                    <p>Описание:</p>
                    <p><?= $item['description'] ?></p>
                </div>

            </div>
    </div>

<?php
echo "</div>";
?>