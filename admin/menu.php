<div class="addItemMenu">
    <?php showMenuForm(); ?>
</div>

<?php
ShowUpMenu();

if ( // существуют и не пустые: Имя & Путь:
    (isset($_POST['itemName']) && !empty($_POST['itemName']))
    &&
    (isset($_POST['itemLink']) && !empty($_POST['itemLink']))
) {
    // add new Item Menu
    if (!EnableItemMenu($_POST['itemName'], "name")) {
        AddUpMenuToEnd($_POST['itemName'], $_POST['itemLink']);
    } // edit Item Menu


}
if (isset($_GET['edit'])) {
    echo "---------- разобраться -------- ";//test
    ShowMenuForm(GetMenuItem($_GET['edit']));
}

if (isset($_GET['Delete'])) {
    DeleteItemFromUpMenu($_GET['Delete']);

}


// после правки:
// header('Location: ' . $_SERVER['PHP_SELF'] . '?section=menu');
// exit;
