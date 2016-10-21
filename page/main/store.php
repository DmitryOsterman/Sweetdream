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
                header('Location: ' . '?action=greetings');
            } else {
                ShowWarnings(checkUser());
                showStore();
            }
            break;

        case 'addUser':
            $errors = ValidateUserItem($_POST);
            if ($errors) {
                renderParams(['errors' => $errors]);
            } else {
                if (FindUserItem(['email' => $_POST['email']])) {
                    renderParams(['errors' => ['Такой человек уже есть']]);
                } else {
                    AddUserItem($_POST['first_name'], $_POST['second_name'],
                        $_POST['address'], $_POST['zip_code'],
                        $_POST['phone'], $_POST['email'],
                        md5($_POST['password']));
                    renderParams(['message' => 'Изменения сохранены']);
                    locationDelay("?action=show", 2000);
                }
            }
            require_once('./authorization/formUser.php');
            break;

        case 'editMode':
            if (checkUser() === true) {
                require_once('./authorization/formUser.php');
            } else {
                ShowWarnings(checkUser());
                showStore();
            }
            break;

        case 'updateUser':
            $errors = ValidateUserItem($_POST);
            if ($errors) {
                renderParams(['errors' => $errors]);
                showStore();
            } else {
                if ($_POST['password'] === GetUserItem(getId())['password']) {
                    // Password not changed!

                    EditUserItem(getId(), $_POST['first_name'], $_POST['second_name'],
                        $_POST['address'], $_POST['zip_code'],
                        $_POST['phone'], $_POST['email'],
                        $_POST['password']);

                } else {
                    // Password changed!

                    EditUserItem(getId(), $_POST['first_name'], $_POST['second_name'],
                        $_POST['address'], $_POST['zip_code'],
                        $_POST['phone'], $_POST['email'],
                        md5($_POST['password']));
                };

                renderParams(['message' => 'Изменения сохранены']);
                locationDelay("?section=show", 2000);
            }
            require_once('./autorization/formUser.php');
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
                header('Location: ?section=cart&action=addAlert&id='
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