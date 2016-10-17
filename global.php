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

function GetUpMenu()
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
    $items = GetUpMenu();
    echo "<ul class='upMenu'>";
    foreach ($items as $item) {
        $link = '?section=common&action=' . $item['link'];
        echo "<li><a href=" . $link . "> $item[name] </a></li>";
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
        ?>
        <li><a href='#'
               onclick="location.href='?section=store&category_id=<?= $item['id'] ?>'">
            <?= $item['name'] ?></a>
        <?php

        if (!$children) continue;
        echo "<ul class='subCatalog'>";
        foreach ($children as $child) {
            ?>
            <li><a href='#'
                   onclick="location.href='?section=store&category_id=<?= $child['id'] ?>'">
                    <?= $child['name'] ?></a></li>
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
    $child = GetCatalogItem($category_id);
    $parent = GetCatalogItem($child['parent_id']);

    $s = "<h4>";
    if ($parent) {
        $s .= $parent['name'] . " / ";
    }
    $s .= $child['name'] . "</h4>";
    echo($s);
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

            <div class='addToCartButton'>
                <a href="<?= $_SERVER['REQUEST_URI'] ?>&action=addFast&id=<?= $item['id'] ?>">
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
        } else {
            echo("HOLD");
        }
        return true;
    } else return false;

}

function showStore()
{
    if (!getId() == '') {
        showItemDetail();
    } else if (!getCategory_id() == '') {
        showCatalogDetail();
    } else showCommon('help');
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
        DestroyCart();
        session_unset();
        setcookie(session_name(), session_id(), time() - 60 * 60 * 24);
        session_destroy();
    }
}

function DestroyCart()
{
    $cart_id = GetUserCart($_SESSION['sess_id'])['id'];
    if (CountCartItems($cart_id) == 0) {
        DeleteCart($cart_id);
    }
}

function startCart()
{
    if (isset($_SESSION['sess_login'])) {
        // find & use the user cart
        $cart_id = GetUserCart($_SESSION['sess_id'])['id'];
        if ($cart_id == '') {
            // create new cart
            $today = date("Y-m-d H:i:s", time()); // (формат MySQL DATETIME)
            $cart_id = AddCart($_SESSION['sess_id'], $today, 'victory!');
            return $cart_id;
        } else {
            // the exists cart is ready to use
            return $cart_id;
        }
    } else {
        // create temp. cart and use them
        return false;
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
    echo "<a href='./admin'>Админ</a>";
}

function loginButton()
{
    if (isset($_SESSION['sess_login'])) {
        printPrivateMenu();
    } else {
        printPublicMenu();
    }
}

function cartButton()
{
    $cart = "<a href='" . $_SERVER['PHP_SELF'] . "?section=cart&action=show'>";
    $cart .= "<img src = '" . ImgUrl() . "basket.png' style='width: 14px'>Корзина";

    if (isset($_SESSION['sess_id'])) {
        if (startCart()) {
            $cart_id = startCart();
            $cart .= "(<b>" . CountCartItems($cart_id) . "</b>)";
        }
    }
    $cart .= "</a>";
    echo($cart);
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
    return isset($_GET['action']) ? $_GET['action'] : 'show';
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

function ShowWarnings($warn)
{
    if (isset($warn) && $warn) {
        ?>
        <div class="centerWarningBlock">
            <?= implode('<br/>', $warn) ?>
        </div>
        <?php
        return true;
    }
    return false;
}

// -------------- cart ----------------------------
function AddCart($user_id, $created, $comment = '')
{
    $sql = "INSERT INTO carts (user_id, created, comment) VALUES (?, ?, ?)";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$user_id, $created, $comment])) {
        print_r($sth->errorInfo());
        die;
    }
    return Db()->lastInsertId();
}

function CountCartItems($cart_id)
{
    if (count(GetCartItemsList($cart_id))) {
        return count(GetCartItemsList($cart_id));
    }

    return 0;
}

function DeleteCart($id)
{
    $sql = "DELETE FROM carts WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function DeleteCartItem($id)
{
    $sql = "DELETE FROM cart_items WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function GetCartItemsList($cart_id)
{
    $sql = "SELECT * FROM cart_items WHERE cart_id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$cart_id])) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetchall();
}

function GetCart($id)
{
    $sql = "SELECT * FROM carts WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetch();
}

function GetCartItem($id)
{
    $sql = "SELECT * FROM cart_items WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetch();
}

function GetUserCart($user_id)
{
    $sql = "SELECT * FROM carts WHERE user_id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$user_id])) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetch();
}

function ValidateCartItem($data)
{
    $errors = [];
    if (!$data['cart_id']) {
        $errors[] = 'Необходимо войти или зарегистрироваться';
    }
    if (!$data['product_id']) {
        $errors[] = 'Необходимо выбрать продукт';
    }
    if (!$data['amount']) {
        $errors[] = 'Необходимо указать количество';
    }
    return $errors;
}

function GetCartId()
{
    if (isset($_SESSION['sess_id'])) {
        $cart_id = GetUserCart($_SESSION['sess_id'])['id'];
        return $cart_id;
    }
    return false;
}

function AddCartItem($cart_id, $product_id, $amount)
{
    $sql = "INSERT INTO cart_items (cart_id, product_id, amount) VALUES (?, ?, ?)";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$cart_id, $product_id, $amount])) {
        print_r($sth->errorInfo());
        die;
    }
    return Db()->lastInsertId();
}

function UpdateCartItem($amount, $id)
{
    $sql = "UPDATE cart_items SET amount=? WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$amount, $id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function AddUpdateCartItem($cart_id, $product_id, $amount)
{
    $CartItems = GetCartItemsList($cart_id);
    foreach ($CartItems as $CartItem) {
        if ($CartItem['product_id'] == $product_id) {
            $ExistCartItem = $CartItem;
            break;
        }
    }
    if (isset($ExistCartItem) && $ExistCartItem['product_id'] == $product_id) {
        $amount += $ExistCartItem['amount'];
        UpdateCartItem($amount, $ExistCartItem['id']);
    } else {
        AddCartItem($cart_id, $product_id, $amount);
    }
}

function ShowCart()
{
    if (GetCartId()) {
        $cart_id = GetCartId();
        $items = GetCartItemsList($cart_id);
        $total = 0;

        echo "<H2>Содержимое корзины</H2>";
        echo "<div class='flowContainer'>";
        foreach ($items as $item) {
            $product = GetProductItem($item['product_id']); // смотрим на этот товар из каталога

            ?>
            <div class='menuItem'>
                <?php if ($product['img_link']) {
                    echo "<img src = " . ImgUrl() . $product['img_link'] . ">";
                } else {
                    echo "<img alt = 'prepare' src = " . ImgUrl() . "no_img.png>";
                }
                ?>

                <a href="<?= $_SERVER['PHP_SELF'] ?>?section=store&id=<?= $product['id'] ?>">
                    <?= $product['name'] ?>
                </a>

                <div class=''>В корзине: <?= $item['amount'] ?> шт.</div>
                <div class=''>По цене: <?= $product['price'] ?> руб.</div>
                <br>

                <div>
                    <a class='CartButtonEdit'
                       href="<?= $_SERVER['PHP_SELF'] ?>?section=cart&action=edit&id=<?= $item['id'] ?>">
                        Edit
                    </a>
                    <a class='CartButtonDelete'
                       href="<?= $_SERVER['PHP_SELF'] ?>?section=cart&action=delete&id=<?= $item['id'] ?>"
                       onclick="return confirm('Вы уверены?');">
                        Delete
                    </a>
                </div>

            </div>
            <?php
            $total += $item['amount'] * GetProductItem($item['product_id'])['price'];
        }
        echo "</div>";
        ?>
        <h4>Итого: <?= $total ?> руб.</h4>
        <button type="submit" class="buttonCart2Order"
                onclick="return confirm('Вы уверены?');">
            Оформить заказ
        </button>

    <?php
    }
}

function EditItemCart()
{

    if (GetCartItem(getId())) {
        $file = './page/main/cart/itemDetail.php';
        if (file_exists($file)) {
            require_once($file);
        } else {
            echo("HOLD");
        }
        return true;
    } else return false;
}

