<?php
function AddCatalogItem($name, $path = '', $parent_id = 0)
{
    $sql = "INSERT INTO catalog (name, link, parent_id) VALUES (?, ?, ?)";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$name, $path, $parent_id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function DeleteCatalogItem($id)
{
    $sql = "DELETE FROM catalog WHERE id=? LIMIT 1";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
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

function UpdateCatalogItem($id, $name, $path = '', $parent_id )
{
    $sql = "UPDATE catalog SET name=?, link=?, parent_id=? WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$name, $path, $parent_id, $id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function FindCatalogItem($params = [])
{
    $keys = array_keys($params);
    $values = array_values($params);

    $where = array_map(function ($a) {
        return $a . '=?';
    }, $keys);
    $sql = "SELECT * FROM catalog WHERE " . implode(' AND ', $where);

    $sth = Db()->prepare($sql);
    if (!$sth->execute($values)) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetchAll();
}

function ValidateCatalogItemForm($data)
{
    $errors = [];
    if (!$data['name']) // if empty
    {
        $errors[] = 'Необходимо ввести название меню';
    }
    return $errors;
}