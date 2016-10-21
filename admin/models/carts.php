<?php

function AddCart($user_id, $created, $comment)
{
    $sql = "INSERT INTO carts (user_id, created, comment) VALUES (?, ?, ?)";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$user_id, $created, $comment])) {
        print_r($sth->errorInfo());
        die;
    }
    return Db()->lastInsertId();
}

function UpdateCart($cart_id, $key, $val)
{
    $sql = "UPDATE carts SET $key=? WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$val, $cart_id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function AddCartItem($cart_id, $product_id, $amount)
{
    $sql = "INSERT INTO cart_items (cart_id, product_id, amount) VALUES (?, ?, ?)";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$cart_id, $product_id, $amount])) {
        print_r($sth->errorInfo());
        die;
    }
    return Db()->lastInsertId();
}

function AddUpdateCartItem($cart_id, $product_id, $amount)
{
    $CartItems = GetCartItemsList($cart_id);
    foreach ($CartItems as $CartItem) {
        if ($CartItem['product_id'] == $product_id) {
            $ExistCartItem = $CartItem;
            break;
        }
    }
    if (isset($ExistCartItem) && $ExistCartItem['product_id'] == $product_id) {
        $amount += $ExistCartItem['amount'];
        UpdateCartItem_amount($amount, $ExistCartItem['id']);
    } else {
        AddCartItem($cart_id, $product_id, $amount);
    }
}

function UpdateCartItem_amount($amount, $id)
{
    $sql = "UPDATE cart_items SET amount=? WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$amount, $id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function DeleteCartItem($id)
{
    $sql = "DELETE FROM cart_items WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function DeleteCart($id)
{
    $sql = "DELETE FROM carts WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function GetCartItem($id)
{
    $sql = "SELECT * FROM cart_items WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetch();
}

function GetCart($id)
{
    $sql = "SELECT * FROM carts WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetch();
}

function GetCartList()
{
    $sql = "SELECT * FROM carts";
    $sth = Db()->prepare($sql);
    if (!$sth->execute()) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetchAll();
}

function GetCartItemsList($cart_id = 0)
{
    $sql = "SELECT * FROM cart_items WHERE cart_id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$cart_id])) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetchall();
}

function print_cart($selected = 0)
{
    $items = GetCartList();
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

function ValidateCart($data)
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

function ValidateCartItem($data)
{
    $errors = [];
    if (!$data['cart_id']) {
        $errors[] = 'Необходимо выбрать корзину';
    }
    if (!$data['product_id']) {
        $errors[] = 'Необходимо выбрать продукт';
    }
    if (!$data['amount']) {
        $errors[] = 'Необходимо указать количество';
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

function CartItems2OrderItems($cart_id)
{
    $sql = "INSERT INTO order_items (product_id, amount, order_id) SELECT product_id, amount, cart_id  FROM cart_items WHERE cart_id = ?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$cart_id])) {
        print_r($sth->errorInfo());
        die;
    }
    return Db()->lastInsertId();
}

function UpdateOrderItems($cart_id, $order_id)
{
    $sql = "UPDATE order_items SET order_id=? WHERE order_id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$order_id, $cart_id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function WriteOrderItemsPrice($order_id)
{
    $sql = "UPDATE order_items, goods SET order_items.price=goods.price WHERE order_items.product_id=goods.id AND order_items.order_id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$order_id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function UpdateGoodItemsAmount($order_id)
{
    $sql = "UPDATE goods, order_items SET goods.amount=goods.amount-order_items.amount WHERE goods.id=order_items.product_id AND order_items.order_id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$order_id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function DeleteCartItems($cart_id)
{
    $cart_items = GetCartItemsList($cart_id);
    foreach ($cart_items as $cart_item) {
        DeleteCartItem($cart_item['id']);
    }
}

function CartToOrder($cart_id, $comment = 'no comment')
{

    $a = GetCart($cart_id);

    $order_id = AddOrder($a['user_id'], $a['created'], 'ordering', $comment);


    CartItems2OrderItems($cart_id);

    //в поле order_id значение было $cart_id, обновляем на $order_id:
    UpdateOrderItems($cart_id, $order_id);

    WriteOrderItemsPrice($order_id);

    UpdateGoodItemsAmount($order_id);

    DeleteCartItems($cart_id);

    DeleteCart($cart_id);

    return $order_id;
}
