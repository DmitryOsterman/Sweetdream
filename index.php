<?php
include_once('./global.php');
include_once('./models/users/users.php');

startSession();
initCart();
ob_start();

$action = getAction();
switch ($action) {
    case 'show':
//        print_r($_SESSION);
//        echo session_id();

        require_once('./models/header.php');
        require_once('./models/store.php');
        require_once('./models/topSales.php');
        require_once('./models/footer.php');
        break;

//    case 'login':
//        header('Location: ?action=show');
//        break;

    case 'checkIn':
        if (checkUser() === true) {
            header('Location: ?action=show');
        } else {
            require_once('./models/header.php');
            warnings(checkUser());
            require_once('./models/store.php');
            require_once('./models/topSales.php');
            require_once('./models/footer.php');
        }
        break;

    case 'reg':
        if (checkUser() === true) {
            header('Location: ?action=show');
        } else {
            require_once('./models/header.php');
            require_once('./models/users/formUser.php');
            require_once('./models/footer.php');
        }
        break;

    case 'addUser':
        require_once('./models/header.php');
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
                locationDelay("?section=show", 2000);
            }
        }
        require_once('./models/users/formUser.php');
        require_once('./models/footer.php');
        break;

    case 'editMode':
        if (checkUser() === true) {
            require_once('./models/header.php');
            require_once('./models/users/formUser.php');
            require_once('./models/footer.php');
        } else {
            require_once('./models/header.php');
            warnings(checkUser());
            require_once('./models/store.php');
            require_once('./models/footer.php');
        }
        break;

    case 'updateUser':
        require_once('./models/header.php');
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
        require_once('./models/users/formUser.php');
        require_once('./models/footer.php');
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