<div class="centerBlock">
    <?php

    $action = getAction();

    if ($action == 'exit') {
        destroySession();
        header('Location:' . $_SERVER['PHP_SELF']);
    } elseif ($action == 'reg') {
        require_once('./authorization/formUser.php');
    } elseif (!($action == '')) {
        showCommon($action);
    }

    ?>
</div>
