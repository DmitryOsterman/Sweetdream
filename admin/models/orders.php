<?php
function AddOrderItem($name, $path = '', $parent_id = 0)
{
    $sql = "INSERT INTO orders (name, link, parent_id) VALUES (?, ?, ?)";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$name, $path, $parent_id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function DeleteOrderItem($id)
{
    $sql = "DELETE FROM orders WHERE id=? LIMIT 1";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function GetOrderList($parent_id = 0)
{
    $sql = "SELECT * FROM orders WHERE parent_id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$parent_id])) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetchall();
}

function GetOrderItem($id)
{
    $sql = "SELECT * FROM orders where id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetch();
}

function UpdateOrderItem($id, $name, $path = '', $parent_id )
{
    $sql = "UPDATE orders SET name=?, link=?, parent_id=? WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$name, $path, $parent_id, $id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function FindOrderItem($params = [])
{
    $keys = array_keys($params);
    $values = array_values($params);

    $where = array_map(function ($a) {
        return $a . '=?';
    }, $keys);
    $sql = "SELECT * FROM orders WHERE " . implode(' AND ', $where);

    $sth = Db()->prepare($sql);
    if (!$sth->execute($values)) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetchAll();
}

function ValidateOrderItemForm($data)
{
    $errors = [];
    if (!$data['name']) // if empty
    {
        $errors[] = 'Необходимо ввести название меню';
    }
    return $errors;
}