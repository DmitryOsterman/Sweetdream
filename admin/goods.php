<?php
$myTable = 'goods';
GoodsForm($myTable, $_GET['edit']);
ShowGoods($myTable);

if (isset($_POST['id']) && !empty($_POST['id'])) {
    EditGoodsItem($myTable, $_POST['itemParent'], $_POST['itemName'],
        $_POST['itemPrice'], $_POST['itemAmount'], $_POST['itemLink'], $_POST['id']);
    header('Location: ' . $_SERVER['PHP_SELF'] . '?section=goods');
    ob_end_flush();
    exit;

} else if (isset($_POST['itemParent'])) {
    AddGoodsItem($myTable, $_POST['itemParent'], $_POST['itemName'],
        $_POST['itemPrice'], $_POST['itemAmount'], $_POST['itemLink']);
    header('Location: ' . $_SERVER['PHP_SELF'] . '?section=goods');
    ob_end_flush();
    exit;
}

if (isset($_GET['delete'])) {
    DeleteItemById($myTable, $_GET['delete']);
    // после удаления, обновить:
    header('Location: ' . $_SERVER['PHP_SELF'] . '?section=goods');
    ob_end_flush();
    exit;
}
