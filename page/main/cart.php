<div class="centerBlock">
    <?php

    $action = getAction();
    switch ($action) {
        case 'show':
            ShowCart();
            break;

        case 'addAlert':
            $item = GetProductItem(getId());
            $message = [];
            $message[] = 'Вы успешно добавили "' . $item['name'] . '" в корзину.';
            $btnOk = true;
            ShowCart(['message' => $message, 'btnOk' => $btnOk]);
            break;

        case 'edit':
            EditCartItem();
            break;

        case 'update':
            $errors = ValidateCartItem($_POST);
            if (!isset ($_POST['amount'])) {
                EditCartItem(['errors' => 'Необходимо указать количество']);
            } else {
                UpdateCartItem_amount($_POST['amount'], getId());
                EditCartItem(['message' => 'Изменения сохранены']);
            }
            break;

        case 'delete':
            DeleteCartItem(getId());
            $message[] = 'Товар удален';
            ShowCart(['message' => $message]);
            break;

        default:
            echo "Это что такое..? " . $action;
            break;
    }
    ?>
</div>