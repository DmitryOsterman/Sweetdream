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

function LoginButton()
{
//    session_start();

//=================================!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    $enter_login = "2";
    $enter_passw = "111";
//=================================!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

    if (isset($_SESSION['sess_login']) && isset($_SESSION['sess_pass'])) {
        if ($_SESSION['sess_login'] === $enter_login &&
            $_SESSION['sess_pass'] === $enter_passw
        ) {
            echo " Информация   для   прошедших   аутентификацию <br><br>\n";
//            echo "<a href=\"exit.php\"> Выйти   из   системы </a>\n";
        } else {
//            header('Location:' . $_SERVER['PHP_SELF']);
//            exit();
        }
    } else
    {
        echo "Вход";
    }
}
//<div id="siteLogin"> Вход</div>

function CartButton()
{
    if (isset($_SESSION['product'])) {
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

function LoginForm()
{
    $mc = '';
    $mc .= '<div class = "formLogin"  align = "right">';
    $mc .= '<form action = "" method = "POST" >';
    $mc .= '<input type = "text" name = "sess_login" placeholder = "Login" />';
    $mc .= '<input type = "text" name = "sess_pass" placeholder = "Password" />';
    $mc .= '<input type = "submit" value = "Вход" />';
    $mc .= '</form ></div >';
    echo $mc;
}
