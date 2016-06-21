<?php
require_once('./db.init');
function InitDbMenu()
{
    global $tbl;
    $tbl = 'upmenu';
    global $dbh;
    try {
        if (!$dbh) {
//            $dbh = new PDO('mysql:host=localhost;dbname=sweetdream', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
            $dbh = new PDO('mysql:host=localhost;dbname=sweetdream', DB_USER, DB_PASSWORD);
            $dbh->query("SET NAMES UTF8");
        }
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

function AddUpMenuToEnd($str, $adr)
{
    global $dbh;
    InitDbMenu();
    global $tbl;
    $sql = "INSERT INTO $tbl VALUES (null, '$str', '$adr')";
    $dbh->query($sql);
}

function GetMenuItem($id)
{
    global $dbh;
    InitDbMenu();
    global $tbl;
    $sql = "SELECT * FROM $tbl WHERE id=?";
    $sth = $dbh->prepare($sql);
    $sth->execute([$id]);
    return $sth->fetch();
}

function EnableItemMenu($str)
{
    global $dbh;
    InitDbMenu();
    global $tbl;
    $q = "SELECT * FROM $tbl WHERE `name` like '$str'";
    $dbData = $dbh->prepare($q);
    $dbData->execute();

    $a = $dbData->fetchAll();
    if (!$a == false) {
        foreach ($a as $row) {
            if ($row[1] == $str) {
                echo("<br>");
                echo "Пункт меню - <b>$row[1]</b> - уже имеется. Введите другое имя";
                echo("<br>");
                return true;
            }
        }
    }
    return false;
}

function DeleteItemFromUpMenu($idItem)
{
    global $dbh;
    InitDbMenu();
    global $tbl;
    $sql = "DELETE FROM $tbl WHERE id=? LIMIT 1";
    $sth = $dbh->prepare($sql);
    $sth->execute([$idItem]);
}

function EditMenuItem($id, $name)
{
    global $dbh;
    InitDbMenu();
    global $tbl;
    $sql = "UPDATE $tbl SET name=? WHERE id=?";
    $sth = $dbh->prepare($sql);
    $sth->execute([$name, $id]);
}

function ShowUpMenu()
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
    echo "</ul>";
}

function ShowMenuForm($row = [])
{
    ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>?section=menu" method="POST">
        <p>Введите пункт меню:</p>
        <input type="hidden" name="id" value="<?= isset($row['id']) ? $row['id'] : '' ?>">
        <label>
            Имя:
            <input type="text" name="newItemName" value="<?= isset($row['name']) ? $row['name'] : '' ?>">
        </label>
        <label>
            Путь:
            <input type="text" name="newItemLink" value="<?= isset($row['link']) ? 'link' : '' ?>">
        </label>
        <input type="submit" value="<?= $row ? 'Edit' : 'Add' ?> item">
    </form>
<?php
}
