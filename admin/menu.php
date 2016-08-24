<?php
require_once('./models/menu.php');

$action = getAction();
switch ($action) {
    case 'show':
        render('menu', 'list');
        break;
    case 'new':
        // вызов формы update/add
        render('menu', 'new');
        break;
    case 'edit':
        // вызов формы update/add
        render('menu', 'edit');
        break;

    case 'add':
        // форма передала:
        // method="post" action="?section=menu&action='add'...
        $errors = ValidateMenuItemForm($_POST); //проверка - не пусто
        if ($errors) {
            render('menu', 'new', ['errors' => $errors]);
        } else {
            if (FindMenuItem(['name' => $_POST['name']])) { //проверка - повторяется?
                render('menu', 'new', ['errors' => ['Такой пункт меню уже есть']]);
            } else {
                AddMenuItem($_POST['name'],$_POST['path']);
                header('Location: ?section=menu');
            }
        }
        break;

    case 'update':
        // method="post" action="?section=menu&action='update'...
        // вызов формы update/add
        $errors = ValidateMenuItemForm($_POST); //проверка - не пусто
        if ($errors) {
            render('menu', 'edit', ['errors' => $errors]);
        } else {
            UpdateMenuItem(getId(), $_POST['name'], $_POST['path']);
            render('menu', 'edit', ['message' => 'Изменения сохранены']);
        }
        break;

    case 'delete':
        DeleteMenuItem(GetId());
        header('Location: ?section=menu');
        break;

    default:
        print 'Это действие я еще обрабатывать не умею :(';
        break;
};