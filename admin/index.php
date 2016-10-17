<?php
require_once('./global.php');

$section = isset($_GET['section']) ? $_GET['section'] : 'menu';
switch ($section) {
    case 'menu':
        require_once('./menu.php');
        break;
    case 'catalog':
        require_once('./catalog.php');
        break;
    case 'goods':
        require_once('./goods.php');
        break;
    case 'users':
        require_once('./users.php');
        break;
    case 'carts':
        require_once('./carts.php');
        break;
    case 'orders':
        require_once('./orders.php');
        break;
    case 'order_items':
        require_once('./order_items.php');
        break;
    case 'cart_items':
        require_once('./cart_items.php');
        break;
    default:
        echo('Неизвестная секция админа');
        break;
}
