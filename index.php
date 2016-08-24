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
        require_once('./models/footer.php');
        break;

    case 'login':
        require_once('./models/header.php');
        require_once('./models/formLogin.php');
        require_once('./models/store.php');
        require_once('./models/footer.php');
        break;

    case 'checkIn':
        if (checkUser() === true) {
            header('Location: ?action=show');
        } else {
            require_once('./models/header.php');
            warnings(checkUser());
            require_once('./models/formLogin.php');
            require_once('./models/store.php');
            require_once('./models/footer.php');
        }
        break;

    case 'reg':
        if (checkUser() === true) {
            header('Location: ?action=show');
        } else {
            require_once('./models/users/header.php');
            require_once('./models/users/formUser.php');
            require_once('./models/users/footer.php');
        }
        break;

    case 'addUser':
        require_once('./models/users/header.php');
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
                locationDelay("?section=users", 2000);
            }
        }
        require_once('./models/users/footer.php');
        break;


    case 'edit':
        if (checkUser() === true) {
            require_once('./models/users/header.php');
            require_once('./models/users/formUser.php');
            require_once('./models/users/footer.php');

        } else {
            require_once('./models/header.php');
            warnings(checkUser());
            require_once('./models/store.php');
            require_once('./models/footer.php');
        }
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