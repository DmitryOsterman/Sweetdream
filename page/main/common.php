<div class="centerBlock">
    <?php
    $action = getAction();

    switch ($action) {

        case 'show':
            showCommon('about');
            break;

        case 'reg':
            require_once('./authorization/formUser.php');
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
                    locationDelay("?action=greetings", 2000);
                }
            }
            require_once('./authorization/formUser.php');
            break;

        case 'exit':
            destroySession();
            header('Location:' . $_SERVER['PHP_SELF']);
            break;

        default:
            showCommon($action);
            break;
    }
    ?>
</div>
