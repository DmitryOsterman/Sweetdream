<?php
ShowMenu();

// существуют Имя & Путь:
if (isset($_POST['itemName']) && isset($_POST['itemLink'])) {

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        EditItemMenu($_POST['id'], $_POST['itemName'], $_POST['itemLink']);
    } else {
        if (IsEnableItemMenu($_POST['itemName'], 'name')) {
            echo "Такой пункт уже имеется. Введите другое наименование";
        } else {
            AddItemMenu($_POST['itemName'], $_POST['itemLink']);
        }
    }
// после редактирования меню, обновить:
    header('Location: ' . $_SERVER['PHP_SELF'] . '?section=menu');
    ob_end_flush();
    exit;

}

if (isset($_GET['edit'])) {

    switch ($_GET['edit']) {
        case 'add':
            ShowEditForm(GetItemMenu($_GET['edit']), 'add');
            break;
        default:
            ShowEditForm(GetItemMenu($_GET['edit']), 'edit');
    }

}

if (isset($_GET['delete'])) {
    DeleteItemMenu($_GET['delete']);
    // после удаления, обновить:
    header('Location: ' . $_SERVER['PHP_SELF'] . '?section=menu');
    ob_end_flush();
    exit;
}
