<?php

function AddOrder($user_id, $created, $status, $comment)
{
    $sql = "INSERT INTO orders (user_id, created, status, comment) VALUES (?, ?, ?, ?)";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$user_id, $created, $status, $comment])) {
        print_r($sth->errorInfo());
        die;
    }
    return Db()->lastInsertId();
}

function AddOrderItem($order_id, $product_id, $amount, $price)
{
    $sql = "INSERT INTO order_items (order_id, product_id, amount, price) VALUES (?, ?, ?, ?)";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$order_id, $product_id, $amount, $price])) {
        print_r($sth->errorInfo());
        die;
    }
    return Db()->lastInsertId();
}

function UpdateOrderItem($amount, $price, $id)
{
    $sql = "UPDATE order_items SET amount=?, price=? WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$amount, $price, $id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function DeleteOrderItem($id)
{
    $sql = "DELETE FROM order_items WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function DeleteOrder($id)
{
    $sql = "DELETE FROM orders WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function GetOrderItem($id)
{
    $sql = "SELECT * FROM order_items WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetch();
}

function GetOrderList()
{
    $sql = "SELECT * FROM orders";
    $sth = Db()->prepare($sql);
    if (!$sth->execute()) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetchAll();
}

function GetOrderItemsList($order_id = 0)
{
    $sql = "SELECT * FROM order_items WHERE order_id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$order_id])) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetchall();
}

function print_order($selected = 0)
{
    $items = GetOrderList();
    foreach ($items as $item) {
        $active = '';
        $user = GetUserItem($item['user_id']);

        if ($item['id'] == $selected) {
            $active = 'selected="selected"';
        }

        $str = '.  Клиент: ';
        $str .= ($user['first_name'] <> '') ? $user['first_name'] : '';
        $str .= ($user['second_name'] <> '') ? ' ' . $user['second_name'] : '';
        $str .= ($user['email'] <> '') ? '.  E-mail: ' . $user['email'] : '';
        $str .= ($item['status'] <> '') ? '.  Статус: ' . $item['status'] : '';

        print '<option value="' . $item['id'] . '" ' . $active . '>' . $item['id']
            . '. Дата и время: ' . $item['created']
            . $str . '</option>';
    }
}

function print_user($selected = 0)
{
    $items = GetUserList();
    foreach ($items as $item) {
        $active = '';
        if ($item['id'] == $selected) {
            $active = 'selected="selected"';
        }
        print '<option value="' . $item['id'] . '" ' . $active . '>'
            . 'id: ' . $item['id']
            . ', Имя: ' . $item['first_name']
            . ', Фамилия: ' . $item['second_name']
            . ', E-mail: ' . $item['email']
            . '</option>';
    }
}

function GetUserList()
{
    $sql = "SELECT * FROM users";
    $sth = Db()->prepare($sql);
    if (!$sth->execute()) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetchall();
}

function GetUserItem($id)
{
    $sql = "SELECT * FROM users WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetch();
}

function ValidateOrder($data)
{
    $errors = [];
    if (!$data['user_id']) {
        $errors[] = 'Необходимо выбрать пользователя';
    }
    if (!$data['created']) {
        $errors[] = 'Необходимо указать дату и время';
    }
    return $errors;
}

function ValidateOrderItem($data)
{
    $errors = [];
    if (!$data['order_id']) {
        $errors[] = 'Необходимо выбрать заказ';
    }
    if (!$data['product_id']) {
        $errors[] = 'Необходимо выбрать продукт';
    }
    if (!$data['amount']) {
        $errors[] = 'Необходимо указать количество';
    }
    if (!$data['price']) {
        $errors[] = 'Необходимо указать цену';
    }
    return $errors;
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

function GetProductList($category_id)
{
    $sql = "SELECT * FROM goods WHERE parent_id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$category_id])) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetchAll();
}

function GetProductItem($id)
{
    $sql = "SELECT * FROM goods WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetch();
}

function print_catalog($parent_id = 0, $selected = 0)
{
    $items = GetCatalogList($parent_id);
    foreach ($items as $item) {
        $active = '';
        $level = $parent_id ? '..... ' : '';
        if ($item['id'] == $selected) {
            $active = 'selected="selected"';
        }
        print '<option value="' . $item['id'] . '" ' . $active . '>' . $level . $item['name'] . '</option>';

        if ($children = GetCatalogList($item['id'])) {
            print_catalog($item['id'], $selected);
        }
    }
}

