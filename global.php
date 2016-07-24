<?php
function print_menu()
{
    $link = mysqli_connect("localhost", "admin_sd", "df9(s1", "sweetdream");
    /* проверка подключения */
    if (mysqli_connect_errno()) {
        printf("Не удалось подключиться: %s\n", mysqli_connect_error());
        exit();
    };
    if ($res = mysqli_query($link, 'SELECT * FROM `upmenu` WHERE 1', MYSQLI_USE_RESULT)) {
        echo "<ul class='hidden upMenu'>";
        while ($content = mysqli_fetch_array($res, MYSQLI_NUM)) {
            echo "<li><a href=$content[2]> $content[1] </a></li>";
        };
        echo "</ul>";
        mysqli_free_result($res);
    }
    /* закрываем подключение */
    mysqli_close($link);
}

function InitCart()
{
    session_start();
    if (isset($_GET['exit'])) {
        session_destroy();
        header('Location:' . $_SERVER['PHP_SELF']);
        ob_end_flush();
    }
    if (isset($_GET['order'])) {
        $new_product = trim(strip_tags($_GET['new_product']));
        if (isset($_SESSION['product'])) {
            array_unshift($_SESSION['product'], $new_product);
        } else {
            $_SESSION['product'] = array($new_product);
        }
        header('Location: ' . $_SERVER['PHP_SELF']);
        ob_end_flush();
    }

}

function CartButton()
{
    if (isset($_SESSION['product'])) {
//        echo "Корзина ";
        $summ = 0;
        foreach ($_SESSION['product'] as $key => $value) {
            //Берем из БД товары, по их ID
        }
        echo "Корзина (<b>" . count($_SESSION['product']) . '</b>)';
    }
    if (count($_SESSION['product']) <= 0) {
        echo "Корзина";
    } else {
        echo "<a href='?exit=true'>Очистить</a>";
    }
}
