<div class="centerBlock">
    <?php

    $action = getAction();
    switch ($action) {
        case 'show':
            ShowCart();
            break;

        case 'edit':
            EditItemCart();
            break;

        case 'update':
            $amount = $_POST['amount'];
            UpdateCartItem($amount, getId());
            header('Location:' . $_SERVER['PHP_SELF'].'?section=cart&action=show');
            break;

        case 'delete':
            DeleteCartItem(getId());
            header('Location:' . $_SERVER['PHP_SELF'].'?section=cart&action=show');
            break;

        default:
            echo "Это что такое..? " . $action;
            break;
    }
    ?>
</div>