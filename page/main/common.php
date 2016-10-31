<div class="centerBlock">
    <?php
    $action = getAction();

    switch ($action) {

        case 'show':
            showCommonFile('about');
            break;

        case 'reg':
            require_once('./authorization/formUser.php');
            break;

        case 'exit':
            destroySession();
            header('Location:' . $_SERVER['PHP_SELF']);
            break;

        default:
            // about, articles, contacts, dealers, delivery, greetings, help
            showCommonFile($action);
            break;
    }
    ?>
</div>
