<?php
if ($_POST) {
    if (getId()) {
        $p = GetUserItem(getId());
    } else {
        $p = [];
    }
    $item = array_merge($p, $_POST, $_GET); // так нужно, чтобы взять id из _GET
} else {
    $item = getId() ? GetUserItem(getId()) : [
        'id' => '',
        'first_name' => '',
        'second_name' => '',
        'address' => '',
        'zip_code' => '',
        'phone' => '',
        'email' => '',
        'password' => ''
    ];
}
?>
<div class="headerEditor">
    <?php if (getId()): ?>
        <h4>Редактирование персональных данных</h4>
    <?php else: ?>
        <h4>Введите свои персональные данные</h4>
    <?php endif; ?>
</div>
<?php if (isset($errors) && $errors): ?>
    <div class="alert alert-danger" role="alert"><?= implode('<br/>', $errors) ?></div>
<?php endif; ?>
<?php if (isset($message) && $message): ?>
    <div class="alert alert-success" role="alert"><?= $message ?></div>
<?php endif; ?>
<div class="userForm">
    <form method="post"
          action="?&action=<?= $item['id'] ? 'updateUser' : 'addUser' ?>&id=<?= $item['id'] ?>">
        <div class="">

            <div class="">
                <label for="first_name">Имя *</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Имя"
                       value="<?= $item['first_name'] ?>">
            </div>
            <div class="">
                <label for="second_name">Фамилия</label>
                <input type="text" class="form-control" id="second_name" name="second_name" placeholder="Фамилия"
                       value="<?= $item['second_name'] ?>">
            </div>
            <div class="">
                <label for="address">Адрес</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Улица, дом, квартира"
                       value="<?= $item['address'] ?>">
            </div>
            <div class="">
                <label for="zip_code">Почтовый индекс</label>
                <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="ZIP код"
                       value="<?= $item['zip_code'] ?>">
            </div>
            <div class="">
                <label for="phone">Телефон</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="+7(xxx)xxxxxxx"
                       value="<?= $item['phone'] ?>">
            </div>
            <div class="">
                <label for="email">E mail *</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="E mail"
                       value="<?= $item['email'] ?>">
            </div>
            <div class="">
                <label for="password">Password *</label>
                <input onclick="confirm ('Change password?')"
                       type="password" class="form-control" id="password"
                       name="password" placeholder="Password"
                       value="<?= $item['password'] ?>">
            </div>
            <p>* - поля обязательные к заполнению</p>
        </div>
        <button type="submit" class="submitButton">Сохранить</button>
    </form>
</div>

