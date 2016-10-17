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

                header('Location: ' . '?action=greetings');
            } else {
                ShowWarnings(checkUser());
            }
            showStore();
            break;

        case 'addUser':
            $errors = ValidateUserItem($_POST);
            if ($errors) {
                renderUser(['errors' => $errors]);
            } else {
                if (FindUserItem(['email' => $_POST['email']])) {
                    renderUser(['errors' => ['Такой человек уже есть']]);
                } else {
                    AddUserItem($_POST['first_name'], $_POST['second_name'],
                        $_POST['address'], $_POST['zip_code'],
                        $_POST['phone'], $_POST['email'],
                        md5($_POST['password']));
                    renderUser(['message' => 'Изменения сохранены']);
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
                renderUser(['errors' => $errors]);
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

                renderUser(['message' => 'Изменения сохранены']);
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
            if (!ShowWarnings($errors)) {

                AddUpdateCartItem($cart_id, $product_id, $amount);

                $category_id = GetProductItem(getId())['parent_id'];
                header('Location: ?section=store&category_id='
                    . $category_id . '&id=' . $product_id);
            }
            showItemDetail();
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
            if (!ShowWarnings($errors)) {
                AddUpdateCartItem($cart_id, $product_id, $amount);

                $category_id = GetProductItem($product_id)['parent_id'];
                header('Location: ?section=store&category_id=' . $category_id);

            } else {
//            showCatalogDetail();
            }

            break;

        case 'search':
            echo 'Searching... ' . $_POST['Search_text'].'. ';
            echo('В разработке');
            break;

        case 'exit':
            destroySession();
            header('Location:' . $_SERVER['REQUEST_URI']);
            break;

        default:
            echo "Это что такое?";
            break;
    }
    ?>
</div>