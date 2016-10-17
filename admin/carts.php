<?php
require_once('./models/carts.php');

$action = getAction();
switch ($action) {
    case 'show':
        render('carts', 'list', $_GET);
        break;
    case 'new':
        render('carts', 'new', $_GET);
        break;
    case 'edit':
        render('carts', 'edit', $_GET);
        break;

    case 'add':
        $errors = ValidateCart($_POST);
        if ($errors) {
            render('carts', 'new', ['errors' => $errors]);
        } else {
            AddCart($_POST['user_id'], $_POST['created'], $_POST['comment']);
            render('carts', 'new', ['message' => 'Изменения сохранены']);
        }
        break;

    case 'addGoods':
        $errors = ValidateCartItem($_POST);
        if ($errors) {
            render('carts', 'edit', ['errors' => $errors]);
        } else {
            AddUpdateCartItem($_POST['cart_id'], $_POST['product_id'], $_POST['amount']);

            // заменить на возврат на пред. стр.
            header('Location: ?section=carts&action=edit&id=' . $_POST['cart_id']);
        }
        break;

    case 'ordering':
        $cart_id = getId();
        $id = CartToOrder($cart_id, 'no_more_comment');
        header('Location: ?section=orders&action=show&id=' . $id);
        break;

    case 'delete':
        DeleteCart(getId());
        header('Location: ?section=carts&action=show');
        break;

    default:
        print 'Это действие я еще обрабатывать не умею :(';
        break;
}