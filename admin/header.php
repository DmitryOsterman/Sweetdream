<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>
    <link rel="stylesheet" href="css/main.css"/>
    <title>Сладкий сон - Режим администратора</title>
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">Сладкий сон</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="<?= getSection() == 'menu' ? 'active' : '' ?>"><a href="?section=menu">Меню</a></li>
                <li class="<?= getSection() == 'catalog' ? 'active' : '' ?>"><a href="?section=catalog">Каталог</a></li>
                <li class="<?= getSection() == 'goods' ? 'active' : '' ?>"><a href="?section=goods">Товары</a></li>
                <li class="<?= getSection() == 'users' ? 'active' : '' ?>"><a href="?section=users">Клиенты</a></li>
                <li class="<?= getSection() == 'carts' ? 'active' : '' ?>"><a href="?section=carts">Корзины</a></li>
                <li class="<?= getSection() == 'orders' ? 'active' : '' ?>"><a href="?section=orders">Заказы</a></li>
            </ul>
        </div>
    </div>
</nav>


<div class="container">
