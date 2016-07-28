<?php
require_once ('./models/menu.php');

$action = getAction();
switch ($action) {
    case 'show':
        render('menu', 'list');
        break;
    case 'new':
        render('menu', 'new');
        break;
    case 'edit':
        render('menu', 'edit');
        break;
    case 'add':
        $errors = ValidateMenuItemForm($_POST);
        if ($errors) {
            render('menu', 'new', ['errors' => $errors]);
        } else {
            if (FindMenuItem(['name' => $_POST['name']])) {
                render('menu', 'new', ['errors' => ['Такой пункт меню уже есть']]);
            } else {
                AddMenuItem($_POST['name']);
                header('Location: ?section=menu');
            }
        }
        break;
    case 'update':
        $errors = ValidateMenuItemForm($_POST);
        if ($errors) {
            render('menu', 'edit', ['errors' => $errors]);
        } else {
            EditMenuItem(getId(), $_POST['name']);
            render('menu', 'edit', ['message' => 'Изменения сохранены']);
        }
        break;
    case 'delete':
        DeleteMenuItem(getId());
        header('Location: ?section=menu');
        break;
    default:
        print 'Это действие я еще обрабатывать не умею :(';
        break;
}
/*
$myTable = 'upmenu';
ShowMenu($myTable);

// существуют Имя & Путь:
if (isset($_POST['itemName']) && isset($_POST['itemLink'])) {

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        EditMenuItem($myTable, $_POST['id'], $_POST['itemName'], $_POST['itemLink']);
    } else {
        if (IsEnItemByValue($myTable, $_POST['itemName'], 'name')) {
            echo "Такой пункт уже имеется. Введите другое наименование";
        } else {
            AddMenuItem($myTable, $_POST['itemName'], $_POST['itemLink']);
        }
    }
// после редактирования меню, обновить:
    header('Location: ' . $_SERVER['PHP_SELF'] . '?section=menu');
    ob_end_flush();
    exit;

}

if (isset($_GET['edit'])) {
    MenuFormEditor(GetItem($myTable, $_GET['edit']), $_GET['edit']);
}

if (isset($_GET['delete'])) {
    DeleteItemById($myTable, $_GET['delete']);
    // после удаления, обновить:
    header('Location: ' . $_SERVER['PHP_SELF'] . '?section=menu');
    ob_end_flush();
    exit;
}
*/