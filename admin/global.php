<?php
require_once('./db.init');
function InitDbMenu()
{
    global $tbl;
    $tbl = 'upmenu';
    global $dbh;
    try {
        if (!$dbh) {
            $dbh = new PDO('mysql:host=localhost;dbname=sweetdream', DB_USER, DB_PASSWORD);
            $dbh->query("SET NAMES UTF8");
        }
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

function AddItemMenu($name, $path)
{
    global $dbh;
    global $tbl;
    InitDbMenu();
    $sql = "INSERT INTO $tbl VALUES (null, '$name', '$path')";
    $dbh->query($sql);
}

function GetItemMenu($id)
{
    InitDbMenu();
    global $dbh;
    global $tbl;
    $sql = "SELECT * FROM $tbl WHERE id=?";
    $sth = $dbh->prepare($sql);
    $sth->execute([$id]);
    return $sth->fetch();
}

function IsEnableItemMenu($name, $ColumnName)
{
    InitDbMenu();
    global $dbh;
    global $tbl;
    $q = "SELECT * FROM $tbl WHERE `$ColumnName` like '$name'";
    $dbData = $dbh->prepare($q);
    $dbData->execute();
    $a = $dbData->fetchAll();
    if (!$a == false) {
        foreach ($a as $row) {
            if ($row[$ColumnName] == $name) {
                return true;
            }
        }
    }
    return false;
}

function IsEnableItemId($myId)
{
    InitDbMenu();
    global $dbh;
    global $tbl;

    echo '<br> ';
    echo 'my id =  ' . $myId;
    echo '<br> ';

    $q = "SELECT * FROM $tbl WHERE `id` like '$myId'";
    $dbData = $dbh->prepare($q);
    $dbData->execute();
    $a = $dbData->fetchAll();
    return $a;
}

function DeleteItemMenu($id)
{
    global $dbh;
    InitDbMenu();
    global $tbl;
    $sql = "DELETE FROM $tbl WHERE id=? LIMIT 1";
    $sth = $dbh->prepare($sql);
    $sth->execute([$id]);
}

function EditItemMenu($id, $name, $path)
{
    InitDbMenu();
    global $dbh;
    global $tbl;
    $sql = "UPDATE $tbl SET name=?, link=? WHERE id=?";
    $sth = $dbh->prepare($sql);
    $sth->execute([$name, $path, $id]);
}

function ShowMenu()
{
    global $dbh;
    InitDbMenu();
    $dbData = $dbh->prepare("SELECT * from `upmenu`");
    $dbData->execute();

    echo "<ul class='myMenu'>";
    foreach ($dbData->fetchAll() as $row) {
        echo "<li>$row[1]";
        echo "<ul class='controls'>";
        echo "<li><a href='?section=menu&edit=$row[0]'>Edit </a></li>";
        echo <<<END
                    <li><a onclick='return confirm("Вы действительно хотите удалить это меню?");'
                    href='?section=menu&Delete=$row[0]'>Delete </a></li>
END;

        //        echo "<a href='/up/$row[2]'>Up </a>";
        //        echo "<a href='/Down/$row[2]'>Down </a>";
        echo "</ul>";
        echo "</li>";
    }
    echo("<li class='newItemMenu'><a href='?section=menu&edit=add'>Add</a></li>");
    echo "</ul>";
}

function ShowEditForm($row = [], $mode)
{
    ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>?section=menu" method="POST">
        <p><?= $mode == 'edit' ? 'Редактирование меню' : 'Добавьте пункт меню' ?>:</p>
        <input type="hidden" name="id" value="<?= isset($row['id']) ? $row['id'] : '' ?>">
        <label>
            Имя:
            <input type="text" name="itemName" value="<?= isset($row['name']) ? $row['name'] : '' ?>">
        </label>
        <label>
            Путь:
            <input type="text" name="itemLink" value="<?= isset($row['link']) ? $row['link'] : '' ?>">
        </label>
        <!--        <input type="submit" value="--><? //= $row ? 'Edit' : 'Add' ?><!-- item">-->
        <input type="submit" value="<?= $mode == 'edit' ? 'Edit' : 'Add' ?> item">
    </form>

<?php
}
