<?php

function Db()
{
    require_once('./config/db.init');
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

function GetCatalogList($parent_id = 0)
{
    $sql = "SELECT * FROM catalog WHERE parent_id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$parent_id])) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetchall();
}

function GetCatalogItem($id)
{
    $sql = "SELECT * FROM catalog where id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetch();
}

function GetProductItem($id)
{
    $sql = "SELECT * FROM goods WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetch();
}

function GetProductList($category_id)
{
    $sql = "SELECT * FROM goods WHERE parent_id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$category_id])) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetchAll();
}

function getUpmenu()
{
    $sql = "SELECT * FROM `upmenu` WHERE 1";
    $sth = Db()->prepare($sql);
    if (!$sth->execute()) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetchall();
}

function ImgUrl()
{
    return "/img/";
}


function printUpmenu()
{
    $items = getUpmenu();
    echo "<ul class='upMenu'>";
    foreach ($items as $item) {
        $link = '?section=common&action=' . $item['link'];
        echo "<li><a href='$link'> $item[name] </a></li>";
    }
    echo "</ul>";
}

function printMenuCatalog()
{
    $items = GetCatalogList();
    echo "<div class='catalogContainer'>";
    echo "<h2>Каталог</h2>";
    echo "<ul class='mainCatalog'>";
    foreach ($items as $item) {
        $children = GetCatalogList($item['id']);
        echo "<li><a href='#'> $item[name] </a>";
        if (!$children) continue;
        echo "<ul class='subCatalog'>";

        foreach ($children as $child) {
            ?>
            <li>
                <a href='#'
                   onclick="location.href='?section=store&category_id=<?= $child['id'] ?>'">
                    <?= $child['name'] ?></a>
            </li>
        <?php
        }

        echo "</ul></li>";
    }
    echo "</ul></div>";
}

function showReviews()
{
    ?>
    <div class="reviewContainer">
        <h2>Отзывы</h2>

        <div class="customer">
            <div class="comment">
                Good shop,
                Quick delivery
            </div>
            <div class="name">Ann</div>
        </div>
    </div>
<?php
}

function showCommon($actionFile)
{
    $file = './page/main/common/' . $actionFile . '.php';
    if (file_exists($file)) {
        require_once($file);
    } else echo("HOLD");
}

function showCatalogDetail()
{
    $category_id = getCategory_id();
    $items = GetProductList($category_id);
    echo "<h4>" . GetCatalogItem(GetCatalogItem($category_id)['parent_id'])['name'];
    echo " / " . GetCatalogItem($category_id)['name'] . "</h4>";

    ?>
    <div class="flowContainer">
    <?php
    foreach ($items as $item) {
        ?>
        <div class='menuItem'>
            <?php if ($item['img_link']) {
                echo "<img src = " . ImgUrl() . $item['img_link'] . ">";
            } else {
                echo "<img alt = 'prepare' src = " . ImgUrl() . "no_img.png>";
            }
            ?>
            <a href="<?= $_SERVER['REQUEST_URI'] ?>&id=<?= $item['id'] ?>">
                <div class='name'> <?= $item['name'] ?></div>
            </a>

            <div class='price'><?= $item['price'] ?> руб.</div>

            <div class='addToCart'>
                <a href="<?= $_SERVER['REQUEST_URI'] ?>&order=<?= $item['id'] ?>">
                    В корзину
                </a>
            </div>
        </div>
    <?php
    }
    echo "</div>";
    return true;
}

function showItemDetail()
{
    if (GetProductItem(getId())) {
        $file = './page/main/store/itemDetail.php';
        if (file_exists($file)) {
            require_once($file);
        } else echo("HOLD");
        return true;
    } else return false;
}

function showStore()
{
    echo "<div class='centerBlock'>";

    if (!getId() == '') {
        showItemDetail();
    } else if (!getCategory_id()=='') {
        showCatalogDetail();
    } else showCommon('help');

    echo "</div>";
}

function greetings()
{
    $file = './templates/greetings.php';
    if (file_exists($file)) {
        require_once($file);
    } else echo("Missing greetings file");
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

function startCart()
{
    if (isset($_GET['order'])) {
        $new_product = trim(strip_tags($_GET['new_product']));
        if (isset($_SESSION['product'])) {
            array_unshift($_SESSION['product'], $new_product);
        } else {
            $_SESSION['product'] = array($new_product);
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
//        header('Location: ' . $_SERVER['PATH']);
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

function adminButton()
{
    require_once('./authorization/formLogin.php');
    echo "<a href='./admin'>Админ</a>";

//     onclick="return toggleElemById('adminLogin')

}

function loginButton()
{
    if (isset($_SESSION['sess_login'])) {
        ?>
        <a href="#"><?= $_SESSION['sess_name'] ?></a>
        <?php
        printPrivateMenu();
    } else {
        require_once('./authorization/formLogin.php');
        ?>
        <a href="#" onclick="return toggleElemById('f_login')">Войти</a>
    <?php
    }
}

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

function helpButton()
{
    ?>
    <a href="<?= $_SERVER['PHP_SELF'] ?>?section=common&action=help">Помощь</a>
<?php
}


// -----------  ----------------
function getAction()
{
    return isset($_GET['action']) ? $_GET['action'] : 'about';
}

function getSection()
{
    return isset($_GET['section']) ? $_GET['section'] : '';
}

function getId()
{
    return isset($_GET['id']) ? $_GET['id'] : '';
}

function getCategory_id()
{
    return isset($_GET['category_id']) ? $_GET['category_id'] : '';
}


function locationDelay($loc, $del)
{
    echo '<script type="text/javascript">setTimeout(function(){window.top.location="' . $loc . '"} ,' . $del . ');</script>';
}

function warnings($warn)
{
    if (isset($warn) && $warn) {
        ?>
        <div class="centerBlock">
            <div class="warning"><?= implode('<br/>', $warn) ?>
            </div>
        </div>
        <?php
        return true;
    }
    return false;
}
