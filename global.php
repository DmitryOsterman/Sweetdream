<?php

function Db()
{
    require_once('./admin/config/db.init');

    global $dbh;
    try {
        if (!$dbh) {
            $dbh = new PDO("mysql:host=localhost;dbname=" . DB_NAME . ';charset=UTF8;', DB_USER, DB_PASSWORD);
        }
    } catch (PDOException $e) {
        die("Error!: " . $e->getMessage() . "<br/>");
    }

    return $dbh;
}


// print_menu - переделать исп. Db()
function print_menu()
{
    $link = mysqli_connect("localhost", "admin_sd", "df9(s1", "sweetdream");
    /* проверка подключения */
    if (mysqli_connect_errno()) {
        printf("Не удалось подключиться: %s\n", mysqli_connect_error());
        exit();
    };
    if ($res = mysqli_query($link, 'SELECT * FROM `upmenu` WHERE 1', MYSQLI_USE_RESULT)) {
        echo "<ul class='upMenu'>";
        while ($content = mysqli_fetch_array($res, MYSQLI_NUM)) {
            echo "<li><a href=$content[2]> $content[1] </a></li>";
        };
        echo "</ul>";
        mysqli_free_result($res);
    }
    /* закрываем подключение */
    mysqli_close($link);
}

function print_privateMenu()
{
    ?>
    <ul class="privateMenu" id="privateMenu">
        <li><a href="?action=editMode<?=
            '&id=' .
            $_SESSION['sess_id'] ?>" id='siteLogin'>Профиль</a></li>
        <li><a href='?action=exit'>Выход</a></li>
    </ul>
<?
}

// ----------- sessions ----------------
function startSession()
{
    if (session_id()) return true;
    else return session_start();
}

function destroySession()
{
    if (session_id()) {
        session_unset();
        setcookie(session_name(), session_id(), time() - 60 * 60 * 24);
        session_destroy();
    }
}

function initCart()
{
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

function checkUser()
{
    $errors = [];
//    $user = FindUserItem(['email' => $_POST['login']]);
//        echo '<pre>';
//        print_r($user);
//        echo '</pre>';

    if (isset($_POST['login']) && isset($_POST['password'])) {

        $user = FindUserItem(['email' => $_POST['login']]);

        if ($_POST['login'] === $user[0]['email'] &&
            md5($_POST['password']) === $user[0]['password']
        ) {
            $_SESSION['sess_login'] = $_POST['login'];
            $_SESSION['sess_pass'] = $_POST['password'];
            $_SESSION['sess_id'] = $user[0]['id'];
            $_SESSION['sess_name'] = $user[0]['first_name'] ? : $user[0]['email'];
            //          " Entering!";
            return true;
        } else {
            //          " Not Enter";
            $errors[] = 'Неверные логин и/или пароль ';
        }
    } else {
        if (isset($_SESSION['sess_login']) && isset($_SESSION['sess_pass'])) {
            if (isset($_GET['id'])) // проверка подмены id
            {
                if (($_GET['id']) == $_SESSION['sess_id']) {
                    return true;
                } else {
                    $errors[] = 'Вы не можете редактировать этого пользователя';
                }
            } else {
                return true;
            }
        } else {
            $errors[] = "Введите логин и/или пароль";
        }
    }
    return $errors;
}


// ----------- menu buttons ----------------
function loginButton()
{
    if (isset($_SESSION['sess_login'])) {
        ?>
        <a href="#"><?= $_SESSION['sess_name'] ?></a><?
        print_privateMenu();
    } else {
        require_once('./models/formLogin.php');
        ?> <a href="#" onclick="return toggleElemById('f_login')">Войти</a> <?
    }
}

//<onMouseOver="" onMouseOut="">

function cartButton()
{
    if (isset($_SESSION['product'])) {

//        foreach ($_SESSION['product'] as $key => $value) {
//            //Берем из БД товары, по их ID
//        }


        if (count($_SESSION['product']) <= 0) {
            echo "<a href='#'>Корзина</a>";
        } else {
            echo "<a href='#'>Корзина (<b>" . count($_SESSION['product']) . "</b>)</a>";
        }
    } else {
        echo "<a href='#'>Корзина</a>";
    }

}


// -----------  ----------------
function getAction()
{
    return isset($_GET['action']) ? $_GET['action'] : 'show';
}

function getId()
{
    return isset($_GET['id']) ? $_GET['id'] : '';
}


function locationDelay($loc, $del)
{
    echo '<script type="text/javascript">setTimeout(function(){window.top.location="' . $loc . '"} ,' . $del . ');</script>';
}

function warnings($warn)
{
    if (isset($warn) && $warn) {
        ?>
        <div class="warning" role="alert"><?= implode('<br/>', $warn) ?></div> <?php
        return true;
    }
}

function showMsg($msg)
{
    if ($msg) {
        ?>
        <div class="warning" role="alert"><?= $msg ?></div>
    <?php
    }
}


function phpAlert($alr)
{
    echo "<script async='async' >alert('$alr');</script>";
}