<?php
require_once('./models/catalog.php');

$action = getAction();
switch ($action) {
    case 'show':
        render('catalog', 'list');
        break;
    case 'new':
        render('catalog', 'new');
        break;
    case 'edit':
        render('catalog', 'edit');
        break;

    case 'add':
        $errors = ValidateCatalogItemForm($_POST); //проверка - не пусто
        if ($errors) {
            render('catalog', 'new', ['errors' => $errors]);
        } else {
            if (FindCatalogItem(['name' => $_POST['name']])) { //проверка - повторяется?
                render('catalog', 'new', ['errors' => ['Такой пункт меню уже есть']]);
            } else {
                AddCatalogItem($_POST['name'], $_POST['path'], $_POST['parent_id']);
                render('catalog', 'new', ['message' => 'Изменения сохранены']);
                locationDelay("?section=catalog", 2000);
            }
        }
        break;

    case 'update':
        $errors = ValidateCatalogItemForm($_POST); //проверка - не пусто
        if ($errors) {
            render('catalog', 'edit', ['errors' => $errors]);
        } else {
            UpdateCatalogItem(getId(), $_POST['name'], $_POST['path'], $_POST['parent_id']);
            render('catalog', 'edit', ['message' => 'Изменения сохранены']);
            locationDelay("?section=catalog", 20000);
        }
        break;

    case 'delete':
        DeleteCatalogItem(GetId());
        header('Location: ?section=catalog');
        break;

    default:
        print 'Это действие я еще обрабатывать не умею :(';
        break;
};