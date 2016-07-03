<?php
$myTable = 'goods';
GoodsFormEditor(GetItem($myTable, $_GET['edit']), $_GET['edit']);
ShowGoods($myTable);

if (isset($_POST['id']) && !empty($_POST['id'])) {
    EditGoodsItem($myTable, $_POST['itemParent'], $_POST['itemName'],
        $_POST['itemPrice'], $_POST['itemAmount'], $_POST['itemLink'], $_POST['id']);

} else {
    AddGoodsItem($myTable, $_POST['itemParent'], $_POST['itemName'],
        $_POST['itemPrice'], $_POST['itemAmount'], $_POST['itemLink']);
//    header('Location: ' . $_SERVER['PHP_SELF'] . '?section=goods');
//    ob_end_flush();
//    exit;
}



// существуют Имя & Путь:
//if (isset($_POST['itemName']) && isset($_POST['itemLink'])) {
//
//    if (isset($_POST['id']) && !empty($_POST['id'])) {
//        EditGoodsItem($myTable, $_POST['$parent_id'], $_POST['$name'], $_POST['$price'],
//            $_POST['$amount'], $_POST['$link'], $_POST['$id']);
//    } else {
//        if (IsEnTableItemByValue($myTable, $_POST['itemName'], 'name')) {
//            echo "Такой пункт уже имеется. Введите другое наименование";
//        } else {
//            AddGoodsItem($myTable, $_POST['$parent_id'], $_POST['$name'], $_POST['$price'],
//                $_POST['$amount'], $_POST['$link']);
//        }
//    }
//// после редактирования меню, обновить:
//    header('Location: ' . $_SERVER['PHP_SELF'] . '?section=goods');
//    ob_end_flush();
//    exit;
//
//}
//
//if (isset($_GET['edit'])) {
//
//    switch ($_GET['edit']) {
//        case 'add':
//            ShowMenuFormEditor(GetTableItem($myTable, $_GET['edit']), 'add');
//            break;
//        default:
//            ShowMenuFormEditor(GetTableItem($myTable, $_GET['edit']), 'edit');
//    }
//}
//
//if (isset($_GET['delete'])) {
//    DeleteTableItemById($myTable, $_GET['delete']);
//    // после удаления, обновить:
//    header('Location: ' . $_SERVER['PHP_SELF'] . '?section=goods');
//    ob_end_flush();
//    exit;
//}
