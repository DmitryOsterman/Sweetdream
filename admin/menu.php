<div class="addItemMenu">
    <?php showMenuForm(); ?>
</div>

<?php
ShowUpMenu();

if ( // существуют и не пустые: Имя & Путь:
    (isset($_POST['newItemName']) && !empty($_POST['newItemName']))
    &&
    (isset($_POST['newItemLink']) && !empty($_POST['newItemLink']))
) {
    $name = $_POST['newItemName'];
    $link = $_POST['newItemLink'];
    echo ("Вы ввели"."<br>");
    echo($name. "<br>");        // контроль ошибок
    echo($link);                // контроль ошибок

    if (isset($_POST['id']) && $_POST['id']) {
        EditMenuItem($_POST['id'], $_POST['newItemName']);
        header('Location: ' . $_SERVER['PHP_SELF'] . '?section=menu');
        exit;
    } else {
        if (!EnableItemMenu($name)) {
            AddUpMenuToEnd($name, $link);

            // после добавления правим заголовок:

            header('Location: ' . $_SERVER['PHP_SELF'] . '?section=menu');
            exit;
        }
    }

}
//else {
//        echo "<br>Введите непустое Имя и Путь";
//    }



if (isset($_GET['Delete'])) {
    DeleteItemFromUpMenu($_GET['Delete']);

    // после удаления правим заголовок:
    header('Location: ' . $_SERVER['PHP_SELF'] . '?section=menu');
    exit;
}

if (isset($_GET['edit'])) {
    ShowMenuForm(GetMenuItem($_GET['edit']));
}

