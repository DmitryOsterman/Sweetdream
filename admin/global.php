<?php
require_once('./db.init');
function InitDbTable($myDBtable)
{
    global $tbl;
    $tbl = $myDBtable;
    $myDBname = DB_NAME;
    global $dbh;
    try {
        if (!$dbh) {
            $dbh = new PDO("mysql:host=localhost;dbname=$myDBname", DB_USER, DB_PASSWORD);
            $dbh->query("SET NAMES UTF8");
        }
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

function AddMenuItem($myDBtable, $name, $path)
{
    InitDbTable($myDBtable);
    global $dbh;
    global $tbl;
    $sql = "INSERT INTO $tbl VALUES (null, '$name', '$path')";
    $dbh->query($sql);
}

function AddGoodsItem($myDBtable, $parent_id, $name, $price, $amount, $link)
{
    InitDbTable($myDBtable);
    global $dbh;
    global $tbl;
    $sql = "INSERT INTO $tbl VALUES (null, '$parent_id', '$name', '$price', '$amount', '$link')";
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

function EditGoodsItem($myDBtable, $parent_id, $name, $price, $amount, $link, $id)
{
    InitDbTable($myDBtable);
    global $dbh;
    global $tbl;
    $sql = "UPDATE $tbl SET parent_id=?, name=?, price=?, amount=?, link=? WHERE id=?";
    $sth = $dbh->prepare($sql);
    $sth->execute([$parent_id, $name, $price, $amount, $link, $id]);
}

function ShowGoods($myDBtable)
{
    global $dbh;
    InitDbTable($myDBtable);
    $mc = '';
    $mc .= '<ul class="mainCatalog">';
    // ---------- 1 Level ---------------
    $dbData = $dbh->prepare("SELECT * from `$myDBtable` WHERE parent_id='0'");
    $dbData->execute();

    foreach ($dbData->fetchAll() as $row) {
        $mc .= '<li><h4>' . $row['name'] . ' (id=' . $row['id'] . ')</h4>' . showGoodsControls('goods', $row['id']);

        // ---------- 2 Level ---------------
        $mc .= '<ul class="subCatalog">';
        $dbData2 = $dbh->prepare("SELECT * from `$myDBtable` WHERE parent_id='" . $row['id'] . "'");
        $dbData2->execute();
        foreach ($dbData2->fetchAll() as $row2) {
            $mc .= '<li>' . $row2['name'] . ' (id=' . $row2['id']  . ')'. showGoodsControls('goods', $row2['id']);

            // ---------- 3 Level = goods ---------------
            $mc .= '<ul>';
            $dbData3 = $dbh->prepare("SELECT * from `$myDBtable` WHERE parent_id='" . $row2['id'] . "'");
            $dbData3->execute();
            foreach ($dbData3->fetchAll() as $row3) {
                $mc .= '<li>' . $row3['name'] . '. Price = ' . $row3['price'] . '. Amount = ' .
                    $row3['amount'] . showGoodsControls('goods', $row3['id']) . '</li>';
            }
            $mc .= '</ul>';
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
        echo showControls('menu', $row[0]);
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

function GoodsFormEditor($myCol = [], $mode)
{
    ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>?section=goods" method="POST">
        <p><?= $mode == 'edit' ? 'Редактирование товара' : 'Добавьте товар или раздел' ?>:</p>
        <input type="hidden" name="id" value="<?= isset($myCol['id']) ? $myCol['id'] : '' ?>">
        <label>
            Наименование:
            <input class="c_itemName" type="text" name="itemName"
                   value="<?= isset($myCol['name']) ? $myCol['name'] : '' ?>">
        </label>
        <label>
            Родительский id:
            <input type="text" name="itemParent" value="<?= isset($myCol['parent_id']) ? $myCol['parent_id'] : '' ?>">
        </label>
        <label>
            Цена:
            <input type="text" name="itemPrice" value="<?= isset($myCol['price']) ? $myCol['price'] : '' ?>">
        </label>
        <label>
            Количество:
            <input type="text" name="itemAmount" value="<?= isset($myCol['amount']) ? $myCol['amount'] : '' ?>">
        </label>
        <label>
            Путь:
            <input type="text" name="itemLink" value="<?= isset($myCol['link']) ? $myCol['link'] : '' ?>">
        </label>
        <input type="submit" value="<?= $mode == 'edit' ? 'Edit' : 'Add' ?> item">
    </form>

<?php
}

function showControls($sec, $id)
{
    $mystr = '';
    $mystr .= "<ul class='controls'>";
    $mystr .= "<li><a href='?section=$sec&edit=$id'>Edit </a></li>";
    $mystr .= <<<END
                    <li><a onclick='return confirm("Вы действительно хотите удалить?");'
                    href='?section=$sec&delete=$id'>Delete </a></li>
END;
    $mystr .= "</ul>";
    return $mystr;
}

function showGoodsControls($sec, $id)
{
    $mystr = '';
    $mystr .= "<ul class='goodsControls'>";
    $mystr .= "<li><a href='?section=$sec&edit=$id'>Edit </a></li>";
    $mystr .= <<<END
                    <li><a onclick='return confirm("Вы действительно хотите удалить?");'
                    href='?section=$sec&delete=$id'>Delete </a></li>
END;
    $mystr .= "</ul>";
    return $mystr;
}