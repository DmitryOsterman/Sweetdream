<?php
$myTable = 'goods';
GoodsForm($myTable, $_GET['edit']);
ShowGoods($myTable);

//  --- редактирование ---
if (isset($_POST['id']) && !empty($_POST['id'])) {
    EditGoodsItem($myTable, $_POST['itemParent'], $_POST['itemName'], $_POST['itemPrice'],
        $_POST['itemAmount'], $_POST['itemLink'], "../img/" . $_POST['itemImage'], $_POST['id']);
    header('Location: ' . $_SERVER['PHP_SELF'] . '?section=goods');
    ob_end_flush();
    exit;
//  --- добавление ---
} else if (isset($_POST['itemParent'])) {
    AddGoodsItem($myTable, $_POST['itemParent'], $_POST['itemName'], $_POST['itemPrice'],
        $_POST['itemAmount'], $_POST['itemLink'], "../img/" . $_POST['itemImage'], $_POST['id']);
    header('Location: ' . $_SERVER['PHP_SELF'] . '?section=goods');
    ob_end_flush();
    exit;
}
//  --- удаление ---
if (isset($_GET['delete'])) {
    DeleteItemById($myTable, $_GET['delete']);
    // после удаления, обновить:
    header('Location: ' . $_SERVER['PHP_SELF'] . '?section=goods');
    ob_end_flush();
    exit;
}
