<?php
include_once('./global.php');
include_once('./authorization/users.php');

startSession();
startCart();
ob_start();

require_once('./page/header.php');
require_once('./page/catalog.php');

$section = getSection();

if (isset($section)) {

    switch ($section) {
        case 'common':
        case '':
            require_once('./page/main/common.php');
            break;

        case 'store':
            require_once('./page/main/store.php');
            break;

        case 'cart':
            require_once('./page/main/cart.php');
            break;

        default:
            echo "Это что такое?";
            break;
    }
}

require_once('./page/footer.php');
