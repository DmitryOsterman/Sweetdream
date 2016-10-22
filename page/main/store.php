<div class="centerBlock">
    <?php

    $action = getAction();
    switch ($action) {
        case 'show':
        case 'help':
        case 'catalog':
            showStore();
            break;

        case 'checkIn':
            if (checkUser() === true) {
                UpdateUserCart();
                header('Location: '
                    . $_SERVER['PHP_SELF'] . '?action=greetings');
            } else {
                ShowWarnings(checkUser());
            }
            break;

        case 'addUser':
            renderAddUserForm();
            break;

        case 'editMode':
            if (checkUser() === true) {
                require_once('./authorization/formUser.php');
            } else {
                ShowWarnings(checkUser());
            }
            break;

        case 'updateUser':
            renderUpdateUserForm();
            break;


        case 'addGoods':
            $product_id = getId();
            $cart_id = GetCartId();
            $amount = '';
            if (isset ($_POST['amount'])) {
                $amount = $_POST['amount'];
            };
            $data = [];
            $data['cart_id'] = $cart_id;
            $data['product_id'] = $product_id;
            $data['amount'] = $amount;

            $errors = ValidateCartItem($data);
            if (!$errors) {
                AddUpdateCartItem($cart_id, $product_id, $amount);
                showItemDetail(['message' => 'Товар добавлен в корзину']);
            } else {
                showItemDetail($errors);
            }
            break;

        case 'addFast':
            $product_id = getId();
            $cart_id = GetCartId();
            $amount = '1';

            $data = [];
            $data['cart_id'] = $cart_id;
            $data['product_id'] = $product_id;
            $data['amount'] = $amount;

            $errors = ValidateCartItem($data);
            if (!$errors) {
                AddUpdateCartItem($cart_id, $product_id, $amount);
                header('Location: ' . $_SERVER['PHP_SELF']
                    . '?section=cart&action=addAlert&id='
                    . GetProductItem($product_id)['id']);
            } else {
                showCatalogDetail($errors);
            }
            break;

        case 'search':
            $foundList = GetSearchGoodsList($_POST['Search_text']);
            if ($foundList) {
                echo '<H4>Мы нашли следующие товары, соответствующие вашему запросу:</H4>';
                showGoodsTable($foundList);
            } else echo('<H4>Ничего не нашлось</H4>');
            break;

        case 'exit':
            destroySession();
            header('Location:' . $_SERVER['PHP_SELF']);
            break;

        default:
            echo "Это что такое?";
            break;
    }
    ?>
</div>