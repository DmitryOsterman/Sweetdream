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

function GetTableItem($myDBtable, $id)
{
    InitDbTable($myDBtable);
    global $dbh;
    global $tbl;
    $sql = "SELECT * FROM $tbl WHERE id=?";
    $sth = $dbh->prepare($sql);
    $sth->execute([$id]);
    return $sth->fetch();
}

function IsEnTableItemByValue($myDBtable, $columnName, $columnValue )
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

function IsEnTableItemById($myDBtable, $id)
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

function DeleteTableItemById($myDBtable, $id)
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

function ShowMenu($myDBtable)
{
    global $dbh;
    InitDbTable($myDBtable);
    $dbData = $dbh->prepare("SELECT * from `$myDBtable`");
    $dbData->execute();

    echo "<ul class='myMenu'>";
    foreach ($dbData->fetchAll() as $row) {
        echo "<li>$row[1]";
        echo "<ul class='controls'>";
        echo "<li><a href='?section=menu&edit=$row[0]'>Edit </a></li>";
        echo <<<END
                    <li><a onclick='return confirm("Вы действительно хотите удалить это меню?");'
                    href='?section=menu&delete=$row[0]'>Delete </a></li>
END;

        //        echo "<a href='/up/$row[2]'>Up </a>";
        //        echo "<a href='/Down/$row[2]'>Down </a>";
        echo "</ul>";
        echo "</li>";
    }
    echo("<li class='newItemMenu'><a href='?section=menu&edit=add'>Add</a></li>");
    echo "</ul>";
}

function ShowEditForm($myCol = [], $mode)
{
    ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>?section=menu" method="POST">
        <p><?= $mode == 'edit' ? 'Редактирование меню' : 'Добавьте пункт меню' ?>:</p>
        <input type="hidden" name="id" value="<?= isset($myCol['id']) ? $myCol['id'] : '' ?>">
        <label>
            Имя:
            <input type="text" name="itemName" value="<?= isset($myCol['name']) ? $myCol['name'] : '' ?>">
        </label>
        <label>
            Путь:
            <input type="text" name="itemLink" value="<?= isset($myCol['link']) ? $myCol['link'] : '' ?>">
        </label>
        <input type="submit" value="<?= $mode == 'edit' ? 'Edit' : 'Add' ?> item">
    </form>

<?php
}
