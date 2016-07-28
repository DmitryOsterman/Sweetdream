<?php
function getSection()
{
    return isset($_GET['section'])? $_GET['section'] : 'menu';
}
function getAction()
{
    return isset($_GET['action'])? $_GET['action'] : 'show';
}
function getId()
{
    return isset($_GET['id'])? $_GET['id'] : '';
}

function Db()
{
    require_once('./config/db.init');

    global $dbh;
    try {
        if (!$dbh) {
            $dbh = new PDO("mysql:host=localhost;dbname=".DB_NAME.';charset=UTF8;', DB_USER, DB_PASSWORD);
        }
    } catch (PDOException $e) {
        die("Error!: " . $e->getMessage() . "<br/>");
    }

    return $dbh;
}

function render($section, $action, $params = [])
{
    $file = './templates/'.$section.'/'.$action.'.php';
    if (file_exists($file)) {
        require_once ('./header.php');
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        require_once ($file);
        require_once ('./footer.php');
    }
}

function ImgPath()
{
    return __DIR__ . DIRECTORY_SEPARATOR . "../img/";
}

function ImgUrl()
{
    return "/img/";
}
/*
function AddMenuItem($myDBtable, $name, $path)
{
    InitDbTable($myDBtable);
    global $dbh;
    global $tbl;
    $sql = "INSERT INTO $tbl VALUES (null, '$name', '$path')";
    $dbh->query($sql);
}

function AddGoodsItem($myDBtable, $parent_id, $name, $price, $amount, $link, $imgLink)
{
    InitDbTable($myDBtable);
    global $dbh;
    global $tbl;
    $sql = "INSERT INTO $tbl VALUES (null, '$parent_id', '$name', '$price', '$amount', '$link', '$imgLink')";
    $dbh->query($sql);
}

function GetItem($myDBtable, $id)
{
    InitDbTable($myDBtable);
    global $dbh;
    global $tbl;
    $sql = "SELECT * FROM $tbl WHERE id=?";
    $sth = $dbh->prepare($sql);
    $sth->execute([$id]);
    return $sth->fetch();
}

function IsEnItemByValue($myDBtable, $columnName, $columnValue)
{
    InitDbTable($myDBtable);
    global $dbh;
    global $tbl;
    $q = "SELECT * FROM $tbl WHERE `$columnName` like '$columnValue'";
    $dbData = $dbh->prepare($q);
    $dbData->execute();
    $a = $dbData->fetchAll();
    if (!$a == false) {
        foreach ($a as $row) {
            if ($row[$columnName] == $columnValue) {
                return true;
            }
        }
    }
    return false;
}

function IsEnItemById($myDBtable, $id)
{
    InitDbTable($myDBtable);
    global $dbh;
    global $tbl;
    $q = "SELECT * FROM $tbl WHERE `id` like '$id'";
    $dbData = $dbh->prepare($q);
    $dbData->execute();
    $a = $dbData->fetchAll();
    return $a;
}

function DeleteItemById($myDBtable, $id)
{
    InitDbTable($myDBtable);
    global $dbh;
    global $tbl;
    $sql = "DELETE FROM $tbl WHERE id=? LIMIT 1";
    $sth = $dbh->prepare($sql);
    $sth->execute([$id]);
}

function EditMenuItem($myDBtable, $id, $name, $path)
{
    InitDbTable($myDBtable);
    global $dbh;
    global $tbl;
    $sql = "UPDATE $tbl SET name=?, link=? WHERE id=?";
    $sth = $dbh->prepare($sql);
    $sth->execute([$name, $path, $id]);
}

function EditGoodsItem($myDBtable, $parent_id, $name, $price, $amount, $link, $imgLink, $id)
{
    InitDbTable($myDBtable);
    global $dbh;
    global $tbl;
    $sql = "UPDATE $tbl SET parent_id=?, name=?, price=?, amount=?, link=?, imgLink=? WHERE id=?";
    $sth = $dbh->prepare($sql);
    $sth->execute([$parent_id, $name, $price, $amount, $link, $imgLink, $id]);
}

function ShowGoods($myDBtable)
{
    global $dbh;
    InitDbTable($myDBtable);
    $mc = '<h2>Каталог</h2>';
    $mc .= '<ul class="mainCatalog">';
    // ---------- 1 Level ---------------
    $dbData = $dbh->prepare("SELECT * from `$myDBtable` WHERE parent_id='0'");
    $dbData->execute();

    foreach ($dbData->fetchAll() as $row) {
        $mc .= '<li><h4>' . $row['name'] . ' (id=' . $row['id'] . ')</h4>' . ShowControls('goods', $row['id'], 'goodsControls');

        // ---------- 2 Level ---------------
        $mc .= '<ul class="subCatalog">';
        $dbData2 = $dbh->prepare("SELECT * from `$myDBtable` WHERE parent_id='" . $row['id'] . "'");
        $dbData2->execute();
        foreach ($dbData2->fetchAll() as $row2) {
            $mc .= '<li><h5>' . $row2['name'] . ' (id=' . $row2['id'] . ')</h5>' . ShowControls('goods', $row2['id'], 'goodsControls');

            // ---------- 3 Level = goods ---------------
            $mc .= '<div class="topSale"><ul>';
            $dbData3 = $dbh->prepare("SELECT * from `$myDBtable` WHERE parent_id='" . $row2['id'] . "'");
            $dbData3->execute();
            foreach ($dbData3->fetchAll() as $row3) {
//                <a href=' . $row3['link'] . '>
                $mc .= '<li>';
                $mc .= '<img src=' . $row3['imgLink'] . '></a>'
                    . '<p>' . 'id=' . $row3['id'] . '. ' . $row3['name'] . '. Price = ' . $row3['price'] . '. Amount = '
                    . $row3['amount'] . '</p>' . ShowControls('goods', $row3['id'], 'goodsControls') . '</li>';
            }


            $mc .= '</ul></div>';
            $mc .= '</li>';
        }
        $mc .= '</ul>';
    }
    $mc .= '</li>';
    $mc .= '</ul>';
    echo $mc;
}

function ShowMenu($myDBtable)
{
    global $dbh;
    InitDbTable($myDBtable);
    $dbData = $dbh->prepare("SELECT * from `$myDBtable`");
    $dbData->execute();
    echo "<ul class='myMenu'>";
    foreach ($dbData->fetchAll() as $row) {
        echo "<li>$row[1]";
        echo ShowControls('menu', $row[0], 'controls');
        echo "</li>";
    }
    echo("<li class='newItemMenu'><a href='?section=menu&edit=add'>Add</a></li>");
    echo "</ul>";
}

function MenuFormEditor($myCol = [], $mode)
{
    ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>?section=menu" method="POST">
        <p><?= $mode == 'add' ? 'Добавьте пункт меню' : 'Редактирование меню' ?>:</p>
        <input type="hidden" name="id" value="<?= isset($myCol['id']) ? $myCol['id'] : '' ?>">
        <label>
            Имя:
            <input type="text" name="itemName" value="<?= isset($myCol['name']) ? $myCol['name'] : '' ?>">
        </label>
        <label>
            Путь:
            <input type="text" name="itemLink" value="<?= isset($myCol['link']) ? $myCol['link'] : '' ?>">
        </label>

        <input type="submit" value="<?= $mode == 'add' ? 'Add' : 'Edit' ?> item">
    </form>

<?php
}

function GoodsForm($myTable, $id)
{
    if (isset($id)) {
        if (IsEnItemById($myTable, $id)) {
            $myCol = GetItem($myTable, $id);
            $mode = 'edit';
        }
    } else {
        $mode = 'add';
    }
    ?>
    <form class="itemProperty" action="<?= $_SERVER['PHP_SELF'] ?>?section=goods" method="POST">
        <h3><?= $mode == 'add' ? 'Добавьте товар или раздел' : "Редактирование товара (id=$id)" ?>:</h3>
        <input type="hidden" name="id" value="<?= isset($myCol['id']) ? $myCol['id'] : '' ?>">
        <label>
            Наименование:
            <input class="formItemName" type="text" name="itemName"
                   value="<?= isset($myCol['name']) ? $myCol['name'] : '' ?>">
        </label>
        <label>
            Родительский id:
            <input type="number" name="itemParent" value="<?= isset($myCol['parent_id']) ? $myCol['parent_id'] : '' ?>">
        </label>
        <label>
            Цена:
            <input type="text" name="itemPrice" value="<?= isset($myCol['price']) ? $myCol['price'] : '' ?>">
        </label>
        <label>
            Количество:
            <input type="number" name="itemAmount" value="<?= isset($myCol['amount']) ? $myCol['amount'] : '' ?>">
        </label>

        <p></p>
        <label>
            Путь:
            <input type="search" name="itemLink" size="110"
                   value="<?= isset($myCol['link']) ? $myCol['link'] : '' ?>">
        </label>

        <p></p>
        <label>
            Фото:
            <input type="text" disabled="disabled" name="oldImage" size="70"
                   value="<?= isset($myCol['imgLink']) ? $myCol['imgLink'] : '' ?>">
            <input type="file" name="itemImage">
        </label>
        <input type="submit" value="<?= $mode == 'edit' ? 'Edit' : 'Add' ?> item">
    </form>

<?php
}

function ShowControls($section, $id, $class)
{
    $mystr = '';
    $mystr .= "<ul class='$class'>";
    $mystr .= "<li><a href='?section=$section&edit=$id'>Edit </a></li>";
    $mystr .= <<<END
                    <li><a onclick='return confirm("Вы действительно хотите удалить?");'
                    href='?section=$section&delete=$id'>Delete </a></li>
END;
    $mystr .= "</ul>";
    return $mystr;
}

function FileUploading()
{
    if (isset($_FILES['image'])) {
        $errors = array();
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));

        $expensions = array("jpeg", "jpg", "png");

        if (in_array($file_ext, $expensions) === false) {
            $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
        }

        if ($file_size > 2097152) {
            $errors[] = 'File size must be excately 2 MB';
        }
        $name = md5(time());
        if (empty($errors) == true) {
//            move_uploaded_file($file_tmp, "../img/" . $file_name);
            move_uploaded_file($file_tmp, "../img/" . $name . "." . $file_ext);
            echo $name . '<br>';
            echo $file_ext . '<br>';
            echo "Success";
        } else {
            print_r($errors);
        }
    }
}

function UploadForm()
{
    ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <label>
            Загрузите фото:
            <input type="file" name="image"/>
        </label>
        <input type="submit" value="Upload"/>
    </form>
<?php
}
*/

