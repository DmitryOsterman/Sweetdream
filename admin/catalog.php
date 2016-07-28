<?php
require_once ('./models/catalog.php');

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
        $errors = ValidateCatalogItemForm($_POST);
        if ($errors) {
            render('catalog', 'new', ['errors' => $errors]);
        } else {
            if (FindCatalogItem(['name' => $_POST['name']])) {
                render('catalog', 'new', ['errors' => ['Такая категория уже есть']]);
            } else {
                AddCatalogItem($_POST['name'], $_POST['parent_id']);
                header('Location: ?section=catalog');
            }
        }
        break;
    case 'update':
        $errors = ValidateCatalogItemForm($_POST);
        if ($errors) {
            render('catalog', 'edit', ['errors' => $errors]);
        } else {
            EditCatalogItem(getId(), $_POST['name'], $_POST['parent_id']);
            render('catalog', 'edit', ['message' => 'Изменения сохранены']);
        }
        break;
    case 'delete':
        DeleteCatalogItem(getId());
        header('Location: ?section=catalog');
        break;
    default:
        print 'Это действие я еще обрабатывать не умею :(';
        break;
}
