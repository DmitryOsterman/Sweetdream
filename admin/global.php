<?php
function getSection()
{
    return isset($_GET['section']) ? $_GET['section'] : 'menu';
}

function getAction()
{
    return isset($_GET['action']) ? $_GET['action'] : 'show';
}

function getId()
{
    return isset($_GET['id']) ? $_GET['id'] : '';
}

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

function render($section, $action, $params = [])
{
    $file = './templates/' . $section . '/' . $action . '.php';
    if (file_exists($file)) {
        require_once('./header.php');
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        require_once($file);
        require_once('./footer.php');
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

function LocationDelay($loc, $del)
{
    echo '<script type="text/javascript">setTimeout(function(){window.top.location="' . $loc . '"} ,' . $del . ');</script>';
}


