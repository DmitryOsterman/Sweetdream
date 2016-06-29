<?php
$myTable = 'upmenu';
ShowMenu($myTable);

// существуют Имя & Путь:
if (isset($_POST['itemName']) && isset($_POST['itemLink'])) {

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        EditMenuItem($myTable, $_POST['id'], $_POST['itemName'], $_POST['itemLink']);
    } else {
        if (IsEnTableItemByValue($myTable, $_POST['itemName'], 'name')) {
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

    switch ($_GET['edit']) {
        case 'add':
            ShowEditForm(GetTableItem($myTable, $_GET['edit']), 'add');
            break;
        default:
            ShowEditForm(GetTableItem($myTable, $_GET['edit']), 'edit');
    }
}

if (isset($_GET['delete'])) {
    DeleteTableItemById($myTable, $_GET['delete']);
    // после удаления, обновить:
    header('Location: ' . $_SERVER['PHP_SELF'] . '?section=menu');
    ob_end_flush();
    exit;
}
