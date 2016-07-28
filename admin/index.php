<?php
require_once ('./global.php');

$section = isset($_GET['section'])? $_GET['section'] : 'menu';
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
}
