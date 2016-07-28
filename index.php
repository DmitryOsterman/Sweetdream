<?php
ob_start();
include_once('global.php');
InitCart();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Сладкий сон</title>
    <meta http-equiv="Content-Type"
          content="text/html; charset=utf8">
    <meta name="description" lang="en" content="Store, Shop, Good Bedding, Bed linen">
    <link rel="stylesheet" type="text/css" media="all" href="css/style.css">

    <script type="text/javascript" src="js/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="js/jquery.dropshadow.js"></script>
    <script type="text/javascript" src="js/jquery.jCarouselLite.js"></script>
    <script type="text/javascript" src="js/mystyle.js"></script>

</head>

<body>


<!------------------------------------------------------>
<div class="siteContainer">

<div class="headerContainer">
    <div class="sawLine"></div>
    <div class="hidden header">

        <div class="titleSite">
            <a href="http://sweetdream/"><h1><b>Сладкий </b>сон </h1></a>
            Постельное белье и качественный трикотаж
        </div>

        <div class="userMenuContainer">
            <ul class="userMenu">
                <li><a href="admin">Админ</a></li>
                <!--                <li><a class="siteLogin" href="#" -->
                <? // "onclick='formLoginToggle'"?><!-- >Вход</a></li>-->
                <li><? LoginButton() ?></li>
                <li><a href="#">Помощь</a></li>
                <li><a href="#"><? CartButton() ?></a></li>
            </ul>
            <!--            formLogin-->
            <? LoginForm() ?>

            <!--            formCart-->
            <div class="searchGoods">
                <form action="search">
                    <input type="search" name="Search" id="idSearch" value=""
                           placeholder="что искать"/>
                    <label for="idSearch"></label>
                    <input class="find" type="image" src="img/find.png"/>
                    <!--<a href="#Search">Поиск</a>-->
                </form>
            </div>
        </div>


    </div>
</div>

<div class="store">
    <?php print_menu(); ?>

    <div class="leftBlock">
        <div class="hidden catalogContainer">
            <h2>Каталог</h2>

            <ul class="mainCatalog">
                <li><a href="#Child">Для детей</a>
                    <ul class="subCatalog">
                        <li><a href="#">Наборы на выписку</a></li>
                        <li><a href="#">Пеленки</a></li>
                        <li><a href="#">Детские ватные матрасы</a></li>
                        <li><a href="#">Детское постельное белье</a></li>
                        <li><a href="#">Детские одеяла</a></li>
                        <li><a href="#">Наборы в кроватку</a></li>
                        <li><a href="#">Наборы для купания</a></li>
                        <li><a href="#">Полотенчики</a></li>
                        <li><a href="#">Трикотаж</a></li>
                        <li><a href="#">Подушки</a></li>
                        <li><a href="#">Покрывала</a></li>
                    </ul>
                </li>
                <li><a href="#Linens">Постельное белье</a>
                    <ul class="subCatalog">
                        <li><a href="#">Бязь</a></li>
                        <li><a href="#">Поплин</a></li>
                        <li><a href="#">Тенсель</a></li>
                        <li><a href="#">Сатин</a></li>
                        <li><a href="#">Полисатин</a></li>
                        <li><a href="#">Поликоттон</a></li>
                        <li><a href="#">Перкаль</a></li>
                        <li><a href="#">Лен</a></li>
                        <li><a href="#">Шёлк</a></li>
                        <li><a href="#">Отдельные предметы</a></li>
                    </ul>
                </li>
                <li><a href="#Pillow">Подушки</a>
                    <ul class="subCatalog">
                        <li><a href="#">"Ортопедические"</a></li>
                        <li><a href="#">"Синтепон"</a></li>
                        <li><a href="#">"Холлофайбер"</a></li>
                        <li><a href="#">"Лебяжий пух"</a></li>
                        <li><a href="#">"Алоэ"</a></li>
                        <li><a href="#">"Бамбук"</a></li>
                        <li><a href="#">"Эвкалипт"</a></li>
                        <li><a href="#">"Водоросли"</a></li>
                        <li><a href="#">"Пухо-перовые"</a></li>
                        <li><a href="#">"Из гречихи"</a></li>
                        <li><a href="#">"Гобеленовые"</a></li>
                        <li><a href="#">"Верблюжья шерсть"</a></li>
                    </ul>
                </li>
                <li><a href="#blankets">Одеяла</a>
                    <ul class="subCatalog">
                        <li><a href="#">Одеяла полушерстяные</a></li>
                        <li><a href="#">Одеяла ватные</a></li>
                        <li><a href="#">Одеяла "Комфорт" холлофайбер</a></li>
                        <li><a href="#">Одеяла овечья шерсть</a></li>
                        <li><a href="#">Одеяла синтепон (полиэфирные)</a></li>
                        <li><a href="#">Одеяла "Лебяжий пух"</a></li>
                        <li><a href="#">Одеяла Бамбук</a></li>
                        <li><a href="#">Одеяла пуховые</a></li>
                        <li><a href="#">Одеяла верблюжьи</a></li>
                        <li><a href="#">Одеяла байковые</a></li>
                        <li><a href="#">Одеяла-покрывала на ватине</a></li>
                    </ul>
                </li>
                <li><a href="#Mattresses">Матрасы</a>
                    <ul class="subCatalog">
                        <li><a href="#">Матрасы ватные</a></li>
                        <li><a href="#">Матрасы поролоновые</a></li>
                    </ul>
                </li>
                <li><a href="#Towels">Полотенца</a>
                    <ul class="subCatalog">
                        <li><a href="#">Махровые</a></li>
                        <li><a href="#">Вафельные</a></li>
                        <li><a href="#">Кухонные</a></li>
                    </ul>
                </li>
                <li><a href="#Coverlets">Покрывала и пледы</a>
                    <ul class="subCatalog">
                        <li><a href="#">Одеяла-покрывала на ватине</a></li>
                        <li><a href="#">Шелковые покрывала</a></li>
                        <li><a href="#">Гобеленовые покрывала</a></li>
                        <li><a href="#">Пледы Шерстяные</a></li>
                    </ul>
                </li>
                <li><a href="#Tablecloths">Скатерти и салфетки</a>
                    <ul class="subCatalog">
                        <li><a href="#">Салфетки</a></li>
                        <li><a href="#">Лен</a></li>
                        <li><a href="#">Хлопок</a></li>
                    </ul>
                </li>
                <li><a href="#blinds">Шторы</a>
                    <ul class="subCatalog">
                        <li><a href="#">Лен</a></li>
                        <li><a href="#">Шелк</a></li>
                    </ul>
                </li>
                <li><a href="#knitwear">Трикотаж</a>
                    <ul class="subCatalog">
                        <li><a href="#">Пижамы</a></li>
                        <li><a href="#">Халаты</a></li>
                        <li><a href="#">Женские футболки и блузки</a></li>
                        <li><a href="#">Платья</a></li>
                        <li><a href="#">Женские толстовки</a></li>
                        <li><a href="#">Ночные сорочки</a></li>
                        <li><a href="#">Костюмы</a></li>
                        <li><a href="#">Батист с шитьем</a></li>
                        <li><a href="#">Мужские толстовки</a></li>
                    </ul>
                </li>
                <li><a href="#Medical">Медицинская одежда</a>
                    <ul class="subCatalog">
                        <li><a href="#">Медицинские костюмы</a></li>
                        <li><a href="#">Медицинские халаты</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="hidden reviewContainer">
            <h2>Отзывы</h2>

            <div class="customer">
                <div class="comment">
                    Good shop,
                    Quick delivery
                </div>
                <div class="name">Ann</div>
            </div>
        </div>


    </div>

    <div class="centerBlock">
        <div class="hidden goodsContainer">
            <!--<h2>Товары</h2>-->
            <div class="mainGoods">

                <div class="item">
                    <a href="#"><img src="img/Grey.jpg"></a>

                    <div class="description">Комплект постельного белья 2-х спальный, шелк</div>
                    <div class="price">5499 руб.</div>
                    <!--<div class="raiting">Рейтинг: 5/5</div>-->
                    <div class="addToCart"><a href="?order=9">В корзину</a></div>
                </div>
            </div>
        </div>


    </div>
</div>

<div class="footerContainer">

    <div class="hidden topSaleContainer">
        <h2>Лидеры продаж</h2>

        <div class="topSale">
            <ul>
                <li><a href="#"><img src="img/x1.jpg"></a>

                    <div class="description">Комплект постельного белья 2-х спальный, шелк</div>
                    <div class="price">5499 руб.</div>
                    <!--<div class="raiting">Рейтинг: 5/5</div>-->
                    <div class="addToCart"><a href="#">В корзину</a></div>

                </li>

                <li><a href="#"><img src="img/x2.jpg"></a>

                    <div class="description">Комплект постельного белья 2-х спальный, шелк</div>
                    <div class="price">5499 руб.</div>
                    <!--<div class="raiting">Рейтинг: 5/5</div>-->
                    <div class="addToCart"><a href="#">В корзину</a></div>
                </li>

                <li><a href="#"><img src="img/s1.jpg"></a>

                    <div class="description">Комплект постельного белья 2-х спальный, бязевый</div>
                    <div class="price">2499 руб.</div>
                    <!--<div class="raiting">Рейтинг: 4/5</div>-->
                    <div class="addToCart"><a href="#">В корзину</a></div>
                </li>

                <li><a href="#"><img src="img/c1.jpg"></a>

                    <div class="description">Комплект постельного белья 2-х спальный, шелк</div>
                    <div class="price">5499 руб.</div>
                    <!--<div class="raiting">Рейтинг: 5/5</div>-->
                    <div class="addToCart"><a href="#">В корзину</a></div>
                </li>

                <li><a href="#"><img src="img/d1.jpg"></a>

                    <div class="description">Комплект постельного белья 2-х спальный, бязевый</div>
                    <div class="price">2499 руб.</div>
                    <!--<div class="raiting">Рейтинг: 4/5</div>-->
                    <div class="addToCart"><a href="#">В корзину</a></div>
                </li>
            </ul>

        </div>
    </div>

</div>

<div class="copyRight">
    <div class="sawLine"></div>
    <small>
        Made by |} {}. 2016
    </small>

</div>

</div>
</body>
</html>