<?php
$items = GetUserList();
?>
<div class="page-header">
    <h4>Клиенты магазина</h4>
</div>
<div class="col-xs-12">
    <button class="btn btn-primary" onclick="location.href='?section=users&action=new&id=<?= getId() ?>'">
        Добавить
    </button>
    <p></p>
    <table class="table table-striped">
        <tr>
            <th>id</th>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Адрес</th>
            <th>Почтовый индекс</th>
            <th>Телефон</th>
            <th>E mail</th>
            <th>Password</th>
        </tr>
        <?php foreach ($items as $item): ?>
            <tr>
                <td>
                    <?= $item['id'] ?>
                </td>
                <td>
                    <?= $item['first_name'] ?>
                </td>
                <td>
                    <?= $item['second_name'] ?>
                </td>
                <td>
                    <?= $item['address'] ?>
                </td>
                <td>
                    <?= $item['zip_code'] ?>
                </td>
                <td>
                    <?= $item['phone'] ?>
                </td>
                <td>
                    <?= $item['email'] ?>
                </td>
                <td>
                    <?= $item['password'] ?>
                </td>

                <td class="text-right">
                    <button type="button" class="btn btn-default btn-sm"
                            onclick="location.href='?section=users&action=edit&id=<?= $item['id'] ?>'">
                        Edit
                    </button>
                    <a href="?section=users&action=delete&id=<?= $item['id'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Вы уверены?');">
                        Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>