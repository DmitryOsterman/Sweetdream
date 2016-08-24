<!DOCTYPE html>
<html>
<head>
    <title>Сладкий сон</title>
    <meta http-equiv="Content-Type"
          content="text/html; charset=utf8">
    <meta name="description" lang="en" content="Store, Shop, Good Bedding, Bed linen">
    <link rel="stylesheet" type="text/css" media="all" href="css/style.css">
    <script type="text/javascript" src="../js/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="../js/jquery.dropshadow.js"></script>
    <script type="text/javascript" src="../js/jquery.jCarouselLite.js"></script>
    <script src="//cdn.rawgit.com/noelboss/featherlight/1.5.0/release/featherlight.min.js" type="text/javascript"
            charset="utf-8"></script>
    <link href="//cdn.rawgit.com/noelboss/featherlight/1.5.0/release/featherlight.min.css" type="text/css"
          rel="stylesheet"/>

    <script type="text/javascript" src="../js/mystyle.js"></script>
</head>
<body>
<div class="siteContainer">
    <div class="headerContainer">
        <div class="sawLine"></div>

        <div class="titleSite">
            <a href="http://sweetdream/"><h1><b>Сладкий </b>сон </h1></a>
            Постельное белье и качественный трикотаж
        </div>

        <ul class="userMenu">
            <li><a href="admin">Админ</a></li>
            <li><? loginButton() ?></li>
            <li><a href="#">Помощь</a></li>
            <li><? cartButton() ?></li>

        </ul>

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
