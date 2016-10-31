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
    require_once('./authorization/reviews.php');
    ?>
    <div class="reviewContainer">
        <h2>Отзывы</h2>

        <div class="customer">
            <div class="comment">
                Good shop,
                Quick delivery
            </div>
            <div class="name">Ann</div>
            <?php

            $obj = new reviews(5);
            echo 'value var = ' . $obj->get() . '<br>';

            ?>
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

// ----------- end sessions ----------------

// no
function ShowVisitsCounter()
{
    if (!isset($_COOKIE['id_count'])) {
        $id_count = 0;
    } else {
        $id_count = $_COOKIE['id_count'];
    }
    $id_count++;
    setcookie('id_count', $id_count, 0x6FFFFFFF);
    header("Content-type: image/png");

    $img = imagecreate(88, 31);
    $grey = imagecolorallocate($img, 128, 128, 128);
    $black = imagecolorallocate($img, 0, 0, 0);
    imagerectangle($img, 0, 0, 87, 30, $black);

    $fontfile = './arial.ttf';
    $str = 'Counter ';
//    $str = iconv("windows-1251", "UTF-8", $str);
    imagettftext($img, 8, 0, 11, 13, $grey, $fontfile, $str);
    $mass = imagettfbbox(12, 0, $fontfile, $id_count);
    $width = intval((88 - $mass[2]) / 2);
    imagettftext($img, 12, 0, $width, 27, $grey, $fontfile, $id_count);
    imagepng($img);
    imagedestroy($img);
}

// no
function createFileCounter()
{
    $dat_file = "counter.dat"; // Файл счетчика
// Открывем файл счетчика и считываем текущий счет
// в переменную $count
    $f = fopen($dat_file, "r");
    $count = fgets($f, 100);
    fclose($f);

    $count = preg_replace(" ", "", $count); // Удаляем символ конца строки
    $count++; // Увеличиваем счетчик
// Записываем данные обратно в файл
    $f = fopen($dat_file, "w");
    fputs($f, "$count ");
    fclose($f);

// Создаем новое изображение из файла
    $im = ImageCreateFromPNG('counter.png');
// Назначаем черный цвет
    $black = ImagecolorAllocate($im, 0, 0, 0);
// Выводим счет на изображение
    Imagestring($im, 1, 5, 20, $count, $black);
// Выводим изображение в стандартный поток вывода
    Header("Content-type: image/png");
    ImagePng($im);
}

// no
function createTxtFileCounter()
{
    $digits = 6;
//Определяет кол-во показываемых чисел – в этом случае 00000x.
    $filelocation = "entercounter.txt";
//Имя файла счетчика.
    if (!file_exists($filelocation)) {
        $newfile = fopen($filelocation, "w+");
        $content = 1;
        fwrite($newfile, $content);
        fclose($newfile);
    }
    $newfile = fopen($filelocation, "r");
    $content = fread($newfile, filesize($filelocation));
    fclose($newfile);
    $newfile = fopen($filelocation, "w+");
    if (!$c) {
        $content++;
    }
    fwrite($newfile, $content);
    fclose($newfile);
    echo "" . sprintf("%0" . "$digits" . "d", $content) . "";
//Если вы хотите, чтобы какой либо текст был вокруг счетчика, заключите строку выше в цитатные кавычки (quotation marks).
}

//-----------------+++++++++++++++++++++++++
// +-
function coolCounter()
{

    /**
     * Графический счётчик посещений
     * Схема работы:
     *  1. устанавливаем куку
     *  2. считываем файл с данными посещений
     *  3. прибавляем хиты
     *  4. если кука не установлена или в ней вчерашняя дата, то прибавляем хосты
     *  5. записываем данные в файл
     *  6. выводим картинку со статистикой
     *
     * @author zg (http://anton-pribora.ru)
     * @package imageCounter
     */

// Выключаем вывод ошибок
    error_reporting(0);

// Запрет кэширования
    header('Expires: Mon, 11 Jul 1991 03:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');

// Объявляем некоторые константы
    define('COOKIE_NAME', '__count_date');
    define('SPLITTER', ' ');
    define('STAT_FILE', 'stat.txt');
    define('TODAY_TIME', time());
    define('TODAY_DATE', date('Y-m-d'));

    define('COUNTER_IMAGE_FILE', 'counter.gif');
    define('COUNTER_IMAGE_TYPE', 'gif');

// Получение куки
    $userTime = isset($_COOKIE[COOKIE_NAME]) ? (int)$_COOKIE[COOKIE_NAME] : null;

// Установка куки
    setcookie(COOKIE_NAME, TODAY_TIME, TODAY_TIME + 60 * 60 * 24);

// Проверка на хост (хостом пусть будет браузер без куки)
    if ($userTime)
        $isNewHost = date('Y-m-d', $userTime) !== TODAY_DATE;
    else
        $isNewHost = true;

// Хитом будем называть просто показ страницы
    $isHit = true;

// Обнуляем суммарные значения счтёчика
    $totalHosts = (int)$isNewHost;
    $totalHits = (int)$isHit;

    $todayHosts = (int)$isNewHost;
    $todayHits = (int)$isHit;

// Открываем файл статистики для чтения и записи
    if ($fp = fopen(STAT_FILE, 'a+b')) {
        // Блокируем файл, чтобы не дать другим процессам переписать файл до его обработки
        if (flock($fp, LOCK_EX)) {
            // Файл успешно блокирован, выполняем его обработку

            // Переводим указатель на начало файла
            fseek($fp, 0, SEEK_SET);

            // Подготавливаем переменные для подсчёта хитов и хостов
            $totalHostsTemp = 0;
            $todayHostsTemp = 0;

            $totalHitsTemp = 0;
            $todayHitsTemp = 0;

            $todayTemp = null;

            // Будем думать, что в файле первая строка содержит нужные данные
            $line = fgets($fp);

            // Пускай в первой строке содержатся: хосты, хиты, хосты за сегодня,
            // хиты за сегодня, дата записи
            if ($line) @list($totalHostsTemp, $totalHitsTemp, $todayHostsTemp,
                $todayHitsTemp, $todayTemp) = preg_split(SPLITTER, $line);

            // Проверка даты
            if ($todayTemp !== TODAY_DATE) {
                // Дата в файле ститистики устарела, обнуляем сегодняшие хосты и хиты
                $todayHostsTemp = 0;
                $todayHitsTemp = 0;
            }

            // Прибавляем данные
            $totalHosts += $totalHostsTemp;
            $todayHosts += $todayHostsTemp;

            $totalHits += $totalHitsTemp;
            $todayHits += $todayHitsTemp;

            // Переводим указатель на начало файла
            fseek($fp, 0, SEEK_SET);

            // Урезаем файл до нулевой длины
            ftruncate($fp, 0);

            // Записываем данные - сначало хосты, хиты, хосты за сегодня,
            // хиты за сегодня, дата
            fputs($fp, join(SPLITTER,
                array($totalHosts, $totalHits, $todayHosts, $todayHits, TODAY_DATE)));

            // Снимаем блокировку, но можно и не снимать, если верить мануалу
            flock($fp, LOCK_UN);
        }

        // Обработка файла завершена, закрываем файловый указатель
        fclose($fp);
    }



// Функция для создания картинки
    $createImageFunction = 'imagecreatefrom' . COUNTER_IMAGE_TYPE;
    $outputImageFunction = 'image' . COUNTER_IMAGE_TYPE;

// Теперь необходимо вывести данные статистики
    if (function_exists($createImageFunction) && function_exists('imagecreatetruecolor')) {
        $yOffset = 2;

        // Если фоновая картинка есть, то используем её
        if (!($im = $createImageFunction(COUNTER_IMAGE_FILE))) {
            // Если фоновой картинки нет, то создаём её
            $imageWidth = 88;
            $imageHeight = 31;
            $yOffset = 8;

            $im = imagecreatetruecolor($imageWidth, $imageHeight);

            $bgColor = imagecolorallocate($im, 220, 220, 220);
            $borderColor = imagecolorallocate($im, 120, 120, 120);

            // Рисуем фоновую картинку
            imagefill($im, 0, 0, $bgColor);
            imagerectangle($im, 0, 0, $imageWidth - 1, $imageHeight - 1, $borderColor);
            imageline($im, $imageWidth - 8, 0, $imageWidth, 8, $borderColor);
            imagefill($im, $imageWidth - 2, 2, $borderColor);
        }

        // Если изображение успешно создано, то выводим счётчик
        if ($im) {


            // Устанавливаем цвет, шрифт и размер
            $fontColor = imagecolorallocate($im, 50, 50, 50);


//            $fontFamily = './arial.ttf';
            $fontSize = '2';

            header('Content-Type: image/' . COUNTER_IMAGE_TYPE);


            imagestring($im, $fontSize, 8, $yOffset, $totalHosts, $fontColor);
            imagestring($im, $fontSize, 55, $yOffset, '+' . $todayHosts, $fontColor);

            $outputImageFunction($im);
            imagedestroy($im);

        }
    } else {
        // Увы, функций для работы с картинками нет
        ?>
        Нет функций для работы с картинками
    <?
    }
}

// no
function statistics()
{

    /**
     * Файл для показа статистики счётчика
     *
     * @author zg
     * @package imageCounter
     */

// Выключаем вывод ошибок
//error_reporting(0);

// Запрет кэширования
    header('Expires: Mon, 11 Jul 1991 03:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');

// Объявляем некоторые константы
    define('SPLITTER', ' ');
    define('STAT_FILE', 'stat.txt');

// Переменные статистики
    $totalHosts = 0;
    $totalHits = 0;

    $todayHosts = 0;
    $todayHits = 0;

    if (file_exists(STAT_FILE) && ($fp = fopen(STAT_FILE, 'rb'))) {
        // Файл статистики существует и доступен для чтения

        // Считываем первую строку
        $line = fgets($fp);
        fclose($fp);

        // Пускай в первой строке содержатся: хосты, хиты,
        // хосты за сегодня, хиты за сегодня, дата записи
        if ($line) @list($totalHosts, $totalHits, $todayHosts, $todayHits) = split(SPLITTER, $line);
    }

    ?>

    <style>
        body {
            font-family: Verdana;
            font-size: 0.8em;
        }

        table {
            font-size: 1em;
        }

        th {
            background-color: #ddd;
            font-weight: normal;
        }

        td.stat {
            border-bottom: 1px #aaa solid;
            border-right: 1px #aaa solid;
        }

        td.today {
            font-weight: bold;
        }

    </style>

    <table cellpadding="4" border="0" align="center">
        <caption>Статистика посещений</caption>
        <colgroup>
            <col align="left"/>
            <col align="center"/>
            <col align="center"/>
        </colgroup>
        <tr>
            <td></td>
            <th>Cегодня</th>
            <th>Всего</th>
        </tr>
        <tr>
            <th>Посетителей</th>
            <td class="stat hosts today"><?= $todayHosts ? '+' : '' ?><?= myNumeric($todayHosts) ?></td>
            <td class="stat hosts total"><?= myNumeric($totalHosts) ?></td>
        </tr>
        <tr>
            <th>Страниц</th>
            <td class="stat hits today"><?= $todayHits ? '+' : '' ?><?= myNumeric($todayHits) ?></td>
            <td class="stat hits total"><?= myNumeric($totalHits) ?></td>
        </tr>
    </table>
    <center>
        <a href="javascript:window.close()">Закрыть окно</a>
    </center>
    <?php
    function myNumeric($num)
    {
        return number_format($num, null, null, ' ');
    }
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
