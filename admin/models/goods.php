<?php
function AddProductItem($name, $description, $category_id, $price, $amount)
{
    $sql = "INSERT INTO goods (name, description, parent_id, price, amount) VALUES (?, ?, ?, ?, ?)";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$name, $description, $category_id, $price, $amount])) {
        print_r($sth->errorInfo());
        die;
    }
    return Db()->lastInsertId();
}

function EditProductItem($id, $name, $description, $category_id, $price, $amount)
{
    $sql = "UPDATE goods SET name=?, description=?, parent_id=?, price=?, amount=?  WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$name, $description, $category_id, $price, $amount, $id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function DeleteProductItem($id)
{
    $sql = "DELETE FROM goods WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
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

function FindProductItem($params = [])
{
    $keys = array_keys($params);
    $values = array_values($params);

    $where = array_map(function ($a) {
        return $a . '=?';
    }, $keys);
    $sql = "SELECT * FROM goods WHERE " . implode(' AND ', $where);
    $sth = Db()->prepare($sql);
    if (!$sth->execute($values)) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetchAll();
}

function ValidateProductItemForm($data)
{
    $errors = [];
    if (!$data['name']) {
        $errors[] = 'Необходимо ввести название меню';
    }
    if (!$data['category_id']) {
        $errors[] = 'Необходимо указать категорию';
    }
    if (!$data['price']) {
        $errors[] = 'Необходимо указать цену';
    }
    return $errors;
}

function AddImageToProductItem($id, $img)
{
    $sql = "UPDATE goods SET img_link=? WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$img, $id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function DeleteImageFromProductItem($id)
{
    $item = GetProductItem($id);
    @unlink(ImgPath() . $item['img_link']);

    $sql = "UPDATE goods SET img_link=? WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute(['', $id])) {
        print_r($sth->errorInfo());
        die;
    }
}
