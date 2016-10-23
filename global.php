<?php

function Db()
{
    require_once('./config/db.init.php');
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
    echo "<div class='upMenu'><ul>";
    foreach ($items as $item) {
        $link = '?section=common&action=' . $item['link'];
        echo "<li><a href=" . $link . "> $item[name] </a></li>";
    }
    echo "</ul></div>";
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

function showCommonFile($actionFile)
{
    $file = './page/main/common/' . $actionFile . '.php';
    if (file_exists($file)) {
        require_once($file);
    } else echo("HOLD");
}

function showCatalogDetail($params = [])
{
    $category_id = getCategory_id();
    $items = GetProductList($category_id);
    $catalog = GetCatalogItem($category_id);
    if ($category_id) {

        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ?>

        <?php if (isset($errors) && $errors): ?>
            <div class="centerWarningBlock"><?= implode('<br/>', $errors) ?></div>
        <?php endif; ?>
        <?php if (isset($message) && $message): ?>
            <div class="centerSuccessBlock"><?= $message ?></div>
        <?php endif; ?>

        <H4 class="CatalogItem">
            <a href="<?= $_SERVER['PHP_SELF'] ?>?section=store&action=show">Каталог</a>
        </H4>
        <span class="separator">»</span>
        <?php
        if ($catalog['parent_id'] == 0) {
            // $catalog - верхний уров.
            ?>
            <H4 class="CatalogItem CatalogItemActive">
                <a href="#">
                    <?= $catalog['name'] ?></a>
            </H4>
            <span class="separator">»</span>
            <?php
            $children = GetCatalogList($category_id);
            foreach ($children as $child) {
                ?>
                <H4 class="CatalogItem">
                    <a href="<?= $_SERVER['PHP_SELF'] ?>?section=store&category_id=<?= $child['id'] ?>">
                        <?= $child['name'] ?>
                    </a></H4>
            <?php
            }
        } else {
            // $catalog - нижний уров.
            $masterCatalog = GetCatalogItem($catalog['parent_id']);
            $child = $catalog;
            ?>
            <H4 class="CatalogItem">
                <a href="<?= $_SERVER['PHP_SELF'] ?>?section=store&category_id=<?= $masterCatalog['id'] ?>">
                    <?= $masterCatalog['name'] ?></a></H4>
            <span class="separator">»</span>
            <H4 class="CatalogItem CatalogItemActive">
                <a href="#">
                    <?= $child['name'] ?>
                </a></H4>
        <?php
        }

        if ($items) {
            showGoodsList($items);
        };

        return true;
    }
    echo('category_id is absence');
    return false;
}

function showGoodsList($items)
{
    echo "<div class='flowContainer'>";
    foreach ($items as $item) {
        ?>
        <div class='menuItem'>
            <?php if ($item['img_link']) {
                echo "<img src = " . ImgUrl() . $item['img_link'] . ">";
            } else {
                echo "<img alt = 'prepare' src = " . ImgUrl() . "no_img.png>";
            }
            ?>
            <a href="<?= $_SERVER['PHP_SELF'] ?>?section=store&id=<?= $item['id'] ?>">
                <div class='name'> <?= $item['name'] ?></div>
            </a>

            <div class='price'><?= $item['price'] ?> руб.</div>

            <div class='addToCartButton'>
                <a href="<?= $_SERVER['PHP_SELF'] ?>?section=store&&category_id=<?=
                $item['parent_id'] ?>&action=addFast&id=<?= $item['id'] ?>"
                   onclick="return confirm('Вы уверены?');">
                    В корзину
                </a>
            </div>
        </div>
    <?php
    }
    echo "</div>";
}

function showGoodsTable($items)
{
    ?>
    <table class="table">
        <tr>
            <th></th>
            <th><h4>Название</h4></th>
            <th><h4>Количество</h4></th>
            <th><h4>Цена, руб</h4></th>
        </tr>
        <?php foreach ($items as $item): ?>
            <tr>
                <td>
                    <?php if ($item['img_link']): ?>
                        <img width="70" src="<?= ImgUrl() . $item['img_link'] ?>">
                    <?php else: ?>
                        <img width="70" src="<?= ImgUrl() . 'no_img.png' ?>">

                    <?php endif; ?>
                </td>
                <td class="description_column">
                    <a href="<?= $_SERVER['PHP_SELF'] ?>?section=store&category_id=<?=
                    $item['parent_id'] ?>&id=<?= $item['id'] ?>">
                        <?= $item['name'] ?>
                    </a>
                </td>
                <td class="amount">
                    <?= $item['amount'] ?>
                </td>
                <td class="price">
                    <?= $item['price'] ?>
                </td>
            </tr>
        <?php
        endforeach; ?>
    </table>

<?php
}

function showItemDetail($params = [])
{

    if (GetProductItem(getId())) {
        $file = './page/main/store/itemDetail.php';
        if (file_exists($file)) {
            foreach ($params as $key => $value) {
                $$key = $value;
            }
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
    } else showCommonFile('help');
}

//function greetings()
//{
//    $file = './templates/greetings.php';
//    if (file_exists($file)) {
//        require_once($file);
//    } else echo("Missing greetings file");
//}


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

function checkUser()
{
    $errors = [];

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
    $cart = '<a href=' . $_SERVER['PHP_SELF'] . '?section=cart&action=show>';
    $cart .= '<img src = ' . ImgUrl() . 'basket.png style=width:14px>Корзина';
    $cart .= "(<b id=cartAmount>" . CountCartItems(GetCartId()) . "</b>)";
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

function LocationDelay($loc, $del)
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

function DestroyCart()
{
    $cart_id = GetUserCart($_SESSION['sess_id'])['id'];
    if (CountCartItems($cart_id) == 0) {
        DeleteCart($cart_id);
    }
}

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
        if (GetUserCart($_SESSION['sess_id'])['id']) {
            return GetUserCart($_SESSION['sess_id'])['id'];
        } else {
            date_default_timezone_set('Europe/Moscow');
            $today = date("Y-m-d H:i:s", time()); // (формат MySQL DATETIME)
            return AddCart($_SESSION['sess_id'], $today, 'User Cart Created success');
        }

    } else {
        if (!isset($_SESSION['cart_id'])) {
            // create temp cart
            date_default_timezone_set('Europe/Moscow');
            $today = date("Y-m-d H:i:s", time()); // (формат MySQL DATETIME)
            $_SESSION['cart_id'] = AddCart(0, $today, 'AutoCreated');
        } else {
        }
        return $_SESSION['cart_id'];
    }
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

function UpdateCartItem_amount($amount, $id)
{
    $sql = "UPDATE cart_items SET amount=? WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$amount, $id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function UpdateCartItem_cartId($new_cart_id, $id)
{
    $sql = "UPDATE cart_items SET cart_id=? WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$new_cart_id, $id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function AddUpdateCartItem($cart_id, $product_id, $amount)
{
    $CartItems = GetCartItemsList($cart_id);
    $ExistCartItem = [];
    // ищем $product_id продукт в корзине покупателя
    foreach ($CartItems as $CartItem) {
        if ($CartItem['product_id'] == $product_id) {
            // нащли
            $ExistCartItem = $CartItem;
//            $Exist = true;
            break;
        }
    }
    if ($ExistCartItem['product_id'] == $product_id) {
        $amount += $ExistCartItem['amount'];
        UpdateCartItem_amount($amount, $ExistCartItem['id']);
    } else {
        AddCartItem($cart_id, $product_id, $amount);
    }
}

function EditCartItem($params = [])
{
    if (GetCartItem(getId())) {
        $file = './page/main/cart/itemDetail.php';
        if (file_exists($file)) {
            foreach ($params as $key => $value) {
                $$key = $value;
            }
            require_once($file);
        } else {
            echo("HOLD");
        }
        return true;
    } else return false;
}

function UpdateUserCart()
{

//  обработаем временн. корз. если она есть
    if (isset($_SESSION['cart_id'])) {
        $items_temp = GetCartItemsList($_SESSION['cart_id']);

        if (count($items_temp) > 0) {

            // если товары были добавлены анонимно
            // перенесем их в корз. пользователя

            $user_cart_id = GetUserCart($_SESSION['sess_id'])['id'];

            if (!$user_cart_id) {
                $user_cart_id = GetCartId();
            }

            // Проблем с корзиной пользователя - НЕТ, continuation

            $items_user = GetCartItemsList($user_cart_id);

            if (count($items_user) == 0) {

                // просто перенесем из врем. корзины в пустую пользователя

                foreach ($items_temp as $item_temp) {
                    UpdateCartItem_cartId($user_cart_id, $item_temp['id']);
                }

            } else {

                // перенесем из врем. корзины в корз. пользователя,
                // с обновлением существ. товаров

                foreach ($items_temp as $item_temp) {
                    foreach ($items_user as $item_user) {
                        if ($item_temp['product_id'] == $item_user['product_id']) {
                            $amount = $item_temp['amount'] + $item_user['amount'];
                            UpdateCartItem_amount($amount, $item_user['id']);
                            DeleteCartItem($item_temp['id']);
                        } else {
                            UpdateCartItem_cartId($user_cart_id, $item_temp['id']);
                        }
                    }
                }

            }

        } else {
            // врем. корзина - пустая
            return true;
        }

    }
    return true;
}

function ShowCart($params = [])
{
    $file = './page/main/cart/showCart.php';
    if (file_exists($file)) {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        require_once($file);
    } else {
        echo("HOLD");
    }
}

// ------------  search --------------------

function GetSearchGoodsList($str)
{
    $str = '%' . $str . '%';
    $sql = "SELECT * FROM goods WHERE (`name` LIKE ?)OR (`description` LIKE ?)";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$str, $str])) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetchAll();
}
