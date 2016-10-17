<!DOCTYPE html>
<html>
<head>
    <title>Сладкий сон</title>
    <meta http-equiv="Content-Type"
          content="text/html; charset=utf8">
    <meta name="description" lang="en" content="Store, Shop, Good Bedding, Bed linen">
    <link rel="stylesheet" type="text/css" media="all" href="./css/style.css">
    <script type="text/javascript" src="../js/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="../js/jquery.dropshadow.js"></script>
    <script type="text/javascript" src="../js/jquery.jCarouselLite.js"></script>
    <script
        src="//cdn.rawgit.com/noelboss/featherlight/1.5.0/release/featherlight.min.js"
        type="text/javascript" charset="utf-8"></script>
    <link href="//cdn.rawgit.com/noelboss/featherlight/1.5.0/release/featherlight.min.css" type="text/css"
          rel="stylesheet"/>
    <script type="text/javascript" src="../js/style.js"></script>
    <script type="text/javascript" src="../js/validate.js"></script>

    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
</head>
<body>
<div class="siteContainer">
    <div class="headerContainer">
        <div class="sawLine"></div>

        <div class="titleSite">
            <a href="<?= $_SERVER['PHP_SELF'] ?>"><h1><b>Сладкий </b>сон </h1></a>
            Постельное белье и качественный трикотаж
        </div>

        <ul class="userMenu">
            <li><?php adminButton() ?></li>
            <li><?php loginButton() ?></li>
            <li><?php helpButton() ?></li>
            <li><?php cartButton() ?></li>
        </ul>

        <div class="searchGoods">
            <form method="post" action="?section=store&action=search">
                <input type="search" name="Search_text" value=""
                       placeholder="Поиск товаров в магазине"/>
                <input class="find" type="image" src="../img/find.png"/>
            </form>
        </div>

    </div>

    <?php printUpmenu(); ?>
<div class="store">
