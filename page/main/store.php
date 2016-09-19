<?php

// header('Location: ?action=show');
// showStore();

$action = getAction();
switch ($action) {
    case 'show':
    case 'help':
    case 'catalog':
        break;

    case 'checkIn':
        if (checkUser() === true) {
            header('Location: ' . '?action=greetings');
        } else {
            warnings(checkUser());
        }
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
            warnings(checkUser());
//            require_once('./models/main.php'); //                        ----????
        }
        break;

    case 'updateUser':
        $errors = ValidateUserItem($_POST);
        if ($errors) {
            renderUser(['errors' => $errors]);
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
//        require_once('./page/main/common.php');

        break;

    case 'exit':
        destroySession();
        header('Location:' . $_SERVER['REQUEST_URI']);
        break;

//    default:
//        echo "Это что такое?";
//        break;
}

showStore();

?>