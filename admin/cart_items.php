<?php
require_once('./models/carts.php');
$action = getAction();
switch ($action) {
    case 'edit':
        render('carts', 'item_editor', $_GET);
        break;
    case 'add':
        $errors = ValidateCartItem($_POST);
        if ($errors) {
            render('carts', 'edit', ['errors' => $errors]);
        } else {
            //AddCartItem($cart_id, $product_id, $amount)
            AddUpdateCartItem($_POST['cart_id'], $_POST['product_id'], $_POST['amount']);


            // заменить на возврат на пред. стр.
            header('Location: ?section=carts&action=edit&id=' . $_POST['cart_id']);


        }
        break;
    case 'update':
        $errors = ValidateCartItem($_POST);
        if ($errors) {
            render('carts', 'item_editor', ['errors' => $errors]);
        } else {
            UpdateCartItem($_POST['amount'], getId());
            render('carts', 'item_editor', ['message' => 'Изменения сохранены']);
        }
        break;
    case 'delete':
        DeleteCartItem(getId());
        // заменить на возврат на пред. стр.
        header('Location: ?section=carts&action=show');
        break;
    default:
        print 'Это действие cart_items я еще обрабатывать не умею :(';
        break;
}

