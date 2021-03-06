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
<div class="page-header">
    <?php if (getId()): ?>
        <h4>Редактирование клиента</h4>
    <?php else: ?>
        <h4>Добавление нового клиента</h4>
    <?php endif; ?>
</div>
<?php if (isset($errors) && $errors): ?>
    <div class="alert alert-danger" role="alert"><?= implode('<br/>', $errors) ?></div>
<?php endif; ?>
<?php if (isset($message) && $message): ?>
    <div class="alert alert-success" role="alert"><?= $message ?></div>
<?php endif; ?>
<form method="post" action="?section=users&action=<?= $item['id'] ? 'update' : 'add' ?>&id=<?= $item['id'] ?>">
    <div class="col-xs-6">
        <label for="first_name">Имя *</label>
        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Имя"
               value="<?= $item['first_name'] ?>">
    </div>
    <div class="col-xs-6">
        <label for="second_name">Фамилия</label>
        <input type="text" class="form-control" id="second_name" name="second_name" placeholder="Фамилия"
               value="<?= $item['second_name'] ?>">
    </div>
    <div class="col-xs-9">
        <label for="address">Адрес</label>
        <input type="text" class="form-control" id="address" name="address"
               placeholder="Улица, дом, квартира" value="<?= $item['address'] ?>">
    </div>
    <div class="col-xs-3">
        <label for="zip_code">Почтовый индекс</label>
        <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="ZIP код"
               value="<?= $item['zip_code'] ?>">
    </div>
    <div class="col-xs-4">
        <label for="phone">Телефон</label>
        <input type="text" class="form-control" id="phone" name="phone" placeholder="+7(xxx)xxxxxxx"
               value="<?= $item['phone'] ?>">
    </div>
    <div class="col-xs-4">
        <label for="email">E mail *</label>
        <input type="text" class="form-control" id="email" name="email" placeholder="E mail"
               value="<?= $item['email'] ?>">
    </div>
    <div class="col-xs-4">
        <label for="password">Password *</label>
        <input type="password" class="form-control" id="password" name="password"
               placeholder="password" value="<?= $item['password'] ?>">
    </div>
    <p>* - поля обязательные к заполнению</p>
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
