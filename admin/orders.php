<?php
require_once('./models/orders.php');

$action = getAction();
switch ($action) {
    case 'show':
        render('orders', 'list', $_GET);
        break;
    case 'new':
        render('orders', 'new', $_GET);
        break;
    case 'edit':
        render('orders', 'edit', $_GET);
        break;

    case 'add':
        $errors = ValidateOrder($_POST);
        if ($errors) {
            render('orders', 'new', ['errors' => $errors]);
        } else {
            AddOrder($_POST['user_id'], $_POST['created'], $_POST['status'], $_POST['comment']);
            render('orders', 'new', ['message' => 'Изменения сохранены']);
        }
        break;

    case 'delete':
        DeleteOrder(getId());
        header('Location: ?section=orders&action=show');
        break;
    default:
        print 'Это действие я еще обрабатывать не умею :(';
        break;
}

