<?php
$items = GetMenuList();
?>
<div class="page-header">
    <h4>Меню</h4>
</div>
<div class="col-xs-6">
    <button class="btn btn-primary" onclick="location.href='?section=menu&action=new'">Добавить</button>
    <p></p>
    <table class="table table-striped">
        <?php foreach ($items as $item): ?>
            <tr>
                <td>
                    <?= $item['name'] ?>
                </td>
                <td class="text-right">
                    <button type="button" class="btn btn-default btn-sm"
                            onclick="location.href='?section=menu&action=edit&id=<?= $item['id'] ?>'">
                        Edit
                    </button>
                    <a href="?section=menu&action=delete&id=<?= $item['id'] ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Вы уверены?');">
                        Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>