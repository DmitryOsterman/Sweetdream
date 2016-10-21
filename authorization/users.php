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

function renderParams($params = [])
{
    foreach ($params as $key => $value) {
        $$key = $value;
    }
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
                <a href="?&action=forgetPass">Забыли пароль?</a></small>
        </div>

    </div>
<?php
}
