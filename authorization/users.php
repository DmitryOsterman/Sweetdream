<?php
function AddUserItem($first_name, $second_name, $address, $zip_code, $phone, $email, $password)
{
    $sql = "INSERT INTO users (first_name, second_name, address, zip_code, phone, email, password)";
    $sql .= "VALUES (?, ?, ?, ?, ?, ?, ?)";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$first_name, $second_name, $address, $zip_code, $phone, $email, $password])) {
        print_r($sth->errorInfo());
        die;
    }
    return Db()->lastInsertId();
}

function EditUserItem($id, $first_name, $second_name, $address, $zip_code, $phone, $email, $password)
{
    $sql = "UPDATE users SET first_name=?, second_name=?, address=?, zip_code=?, phone=?, email=?, password=?";
    $sql .= "WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$first_name, $second_name, $address, $zip_code, $phone, $email, $password, $id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function DeleteUserItem($id)
{
    $sql = "DELETE FROM users WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
}

function GetUserItem($id)
{
    $sql = "SELECT * FROM users WHERE id=?";
    $sth = Db()->prepare($sql);
    if (!$sth->execute([$id])) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetch();
}

function GetUserList()
{
    $sql = "SELECT * FROM users";
    $sth = Db()->prepare($sql);
    if (!$sth->execute()) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetchall();
}

function ValidateUserItem($data)
{
    $errors = [];

    if (!$data['first_name']) {
        $errors[] = 'Необходимо ввести Имя';
    }
    if (!$data['email']) {
        $errors[] = 'Необходимо ввести E-mail';
    }
    if (!$data['password']) {
        $errors[] = 'Необходимо ввести пароль';
    }
    return $errors;
}

function FindUserItem($params = [])
{
    $keys = array_keys($params);
    $values = array_values($params);

    $where = array_map(function ($a) {
        return $a . '=?';
    }, $keys);
    $sql = "SELECT * FROM users WHERE " . implode(' AND ', $where);
    $sth = Db()->prepare($sql);
    if (!$sth->execute($values)) {
        print_r($sth->errorInfo());
        die;
    }
    return $sth->fetchAll();
}

function printPrivateMenu()
{
    ?>
    <a href="#"><?= $_SESSION['sess_name'] ?></a>
    <ul class="privateMenu">
        <li class='privateMenuFirst'><a
                href="?section=store&action=editMode<?=
                '&id='
                . $_SESSION['sess_id'] ?>" id='siteLogin'>Профиль</a></li>
        <li><a href='?action=exit' onclick="return confirm('Уже уходите?')">Выход</a></li>
    </ul>
<?php
}

function printPublicMenu()
{
    ?>
    <a href="#" onclick="toggleElemById('f_login')" id="closeFormLogin">Войти</a>

    <div class="formLogin" id="f_login">

        <form action="?section=store&action=checkIn" method="POST">
            <label>Введите логин</label>
            <input type="text" id="f_login" name="login" placeholder="E-mail"/>

            <label>Введите пароль</label>
            <input type="password" id="f_password" name="password" placeholder="Password"/>

            <button class="submitButton" type="submit">Вход</button>
            <button class="submitButton" type="reset">Сброс</button>

        </form>

        <div class="">
            <small><a href="?action=reg">Зарегистрироваться</a><br>
                <a href="?action=forgetPass">Забыли пароль?</a></small>
        </div>

    </div>
<?php
}

function showUserDetail($params = [])
{
    $file = './authorization/formUser.php';
    if (file_exists($file)) {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        require_once($file);
    } else {
        echo("HOLD");
    }
    return true;
}

function renderAddUserForm()
{
    $errors = ValidateUserItem($_POST);
    if ($errors) {
        showUserDetail(['errors' => $errors]);
    } else {
        if (FindUserItem(['email' => $_POST['email']])) {
            showUserDetail(['errors' => ['Такой человек уже есть']]);
        } else {
            AddUserItem($_POST['first_name'], $_POST['second_name'],
                $_POST['address'], $_POST['zip_code'],
                $_POST['phone'], $_POST['email'],
                md5($_POST['password']));

            showUserDetail(['message' => 'Вы успешно зарегистрированы. Вам на почту направлено письмо с приветом))']);

            ConfirmEmail($_POST['email']);

            LocationDelay($_SERVER['PHP_SELF'] . '?action=greetings', 5000);
        }
    }
}

function renderUpdateUserForm()
{
    $errors = ValidateUserItem($_POST);
    if ($errors) {
        showUserDetail(['errors' => $errors]);
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
        showUserDetail(['message' => 'Изменения сохранены']);
    }
}

function ConfirmEmail($user_mail)
{
    $msg = " Добрый   день !<br><br>\n";
    $msg .= " Вы успешно зарегистрированы в нашем магазинчике. <br><br>\n";
    $msg .= "Спасибо что пользуетесь нашими услугами.<br><br>\n";
    $msg .= "<a href=\"http://sweetdream.mixtline.com/\">Сладкий сон</a><br>\n";
    $msg .= "support@sweetdream.mixtline.com";
    $Ot = " Суппорт ";
    $Ot = "=?windows-1251?B?" . base64_encode($Ot) . "?=";
    $header = "Content-Type: text/html; charset=windows-1251\r\n";
    $header .= "From: " . $Ot . " <support@sweetdream.mixtline.com>";
    $subject = " Сообщение магазинчика 'Сладкий сон'";
    $subject = "=?windows-1251?B?" . base64_encode($subject) . "?=";
    mail($user_mail, $subject, $msg, $header);
}