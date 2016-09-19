<?php
require_once('./models/orders.php');

$action = getAction();
switch ($action) {
    case 'show':
        render('orders', 'list');
        break;
    case 'new':
        render('orders', 'new');
        break;
    case 'edit':
        render('orders', 'edit');
        break;

    case 'add':
        $errors = ValidateOrderItemForm($_POST); //проверка - не пусто
        if ($errors) {
            render('orders', 'new', ['errors' => $errors]);
        } else {
            if (FindOrderItem(['name' => $_POST['name']])) { //проверка - повторяется?
                render('orders', 'new', ['errors' => ['Такой пункт меню уже есть']]);
            } else {
                AddOrderItem($_POST['name'], $_POST['path'], $_POST['parent_id']);
                render('orders', 'new', ['message' => 'Изменения сохранены']);
                locationDelay("?section=orders", 2000);
            }
        }
        break;

    case 'update':
        $errors = ValidateOrderItemForm($_POST); //проверка - не пусто
        if ($errors) {
            render('orders', 'edit', ['errors' => $errors]);
        } else {
            UpdateOrderItem(getId(), $_POST['name'], $_POST['path'], $_POST['parent_id']);
            render('orders', 'edit', ['message' => 'Изменения сохранены']);
            locationDelay("?section=orders", 20000);
        }
        break;

    case 'delete':
        DeleteOrderItem(GetId());
        header('Location: ?section=orders');
        break;

    default:
        print 'Это действие я еще обрабатывать не умею :(';
        break;
};