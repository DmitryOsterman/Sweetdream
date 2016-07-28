<?php
function AddCatalogItem($name, $parent_id = 0)
{
    $sql = "INSERT INTO catalog (name, parent_id) VALUES (?, ?)";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$name, $parent_id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function EditCatalogItem($id, $name, $parent_id = 0)
{
    $sql = "UPDATE catalog SET name=?, parent_id=? WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$name, $parent_id, $id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function DeleteCatalogItem($id)
{
    $sql = "DELETE FROM catalog WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function GetCatalogItem($id)
{
    $sql = "SELECT * FROM catalog WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetch();
}

function GetCatalogList($parent_id = 0)
{
    $sql = "SELECT * FROM catalog WHERE parent_id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$parent_id])) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetchAll();
}

function FindCatalogItem($params = [])
{
    $keys = array_keys($params);
    $values = array_values($params);

    $where = array_map(function($a){return $a.'=?';}, $keys);
    $sql = "SELECT * FROM catalog WHERE ".implode(' AND ', $where);
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
    if (!$data['name']) {
        $errors[] = 'Необходимо ввести название меню';
    }
    return $errors;
}