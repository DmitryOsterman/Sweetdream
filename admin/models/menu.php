<?php
function AddMenuItem($name, $path = '')
{
    $sql = "INSERT INTO upmenu (name, link) VALUES (?, ?)";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$name, $path])) {
        print_r($sth->errorInfo());
        die;
    }
}

function EditMenuItem($id, $name, $path = '')
{
    $sql = "UPDATE upmenu SET name=?, link=? WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$name, $path, $id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function DeleteMenuItem($id)
{
    $sql = "DELETE FROM upmenu WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function GetMenuItem($id)
{
    $sql = "SELECT * FROM upmenu WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetch();
}

function GetMenuList()
{
    $sql = "SELECT * FROM upmenu";
    $sth = Db()->prepare($sql);
    if (!$sth->execute()) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetchAll();
}

function FindMenuItem($params = [])
{
    $keys = array_keys($params);
    $values = array_values($params);

    $where = array_map(function($a){return $a.'=?';}, $keys);
    $sql = "SELECT * FROM upmenu WHERE ".implode(' AND ', $where);
    $sth = Db()->prepare($sql);
    if (!$sth->execute($values)) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetchAll();
}

function ValidateMenuItemForm($data)
{
    $errors = [];
    if (!$data['name']) {
        $errors[] = 'Необходимо ввести название меню';
    }
    return $errors;
}