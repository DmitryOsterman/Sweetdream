<?php
require_once('./models/orders.php');
$action = getAction();
switch ($action) {
    case 'edit':
        render('orders', 'item_editor', $_GET);
        break;
    case 'add':
        $errors = ValidateOrderItem($_POST);
        if ($errors) {
            render('orders', 'edit', ['errors' => $errors]);
        } else {
            AddOrderItem($_POST['order_id'], $_POST['product_id'],
                $_POST['amount'], $_POST['price']);


            // заменить на возврат на пред. стр.
            header('Location: ?section=orders&action=edit&id=' . $_POST['order_id']);


        }
        break;
    case 'update':
        $errors = ValidateOrderItem($_POST);
        if ($errors) {
            render('orders', 'item_editor', ['errors' => $errors]);
        } else {
            UpdateOrderItem($_POST['amount'], $_POST['price'], getId());
            render('orders', 'item_editor', ['message' => 'Изменения сохранены']);
        }
        break;
    case 'delete':
        DeleteOrderItem(getId());
        // заменить на возврат на пред. стр.
        header('Location: ?section=orders&action=show');
        break;
    default:
        print 'Это действие order_items я еще обрабатывать не умею :(';
        break;
}

