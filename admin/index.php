<?php
ob_start();
include_once('global.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Сладкий сон / Настройка</title>
    <meta http-equiv="Content-Type"
          content="text/html; charset=utf8">
    <meta name="description" lang="en" content="Setup the shop">
    <link rel="stylesheet" type="text/css" media="all" href="css/style.css">
    <!--    <script type="text/javascript" src="js/mystyle.js"></script>-->
</head>
<body>

<!------------------------------------------------------>
<div class="siteContainer">
    <div class="titleSite">
        <h1><b>Сладкий </b>сон</h1>
        <!--        <h3>Настройка Меню</h3>-->
    </div>

    <div class="store">

        <ul class="upMenu"><li>
			<a href="?section=main">Главная</a></li><li>
			<a href="?section=menu">Меню</a></li><li>
			<a href="?section=goods">Товары</a></li><li>
			<a href="#">Картинки</a></li>
        </ul>

        <?php
        if (isset($_GET['section'])) {
            switch ($_GET['section']) {
                case 'menu':
                    require "menu.php";
                    break;
                case 'goods':
                    require "goods.php";
                    break;
                case 'main':
                    require "main.php";
                    break;
            }
        } else {
            require "main.php";
        }
        ?>

        <div class="copyRight">
            <small>
                Made by |} {}. 2016
            </small>
        </div>
    </div>
</body>
</html>