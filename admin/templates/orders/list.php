<?php
$items = GetCatalogList();
?>
<div class="page-header">
    <h4>Каталог</h4>
</div>
<div class="col-xs-6">
    <button class="btn btn-primary" onclick="location.href='?section=catalog&action=new'">Добавить</button>
    <p></p>
    <table class="table table-striped">
        <?php foreach ($items as $item): ?>
            <tr>
                <td>
                    <?= $item['name'] ?>
                </td>
                <td class="text-right">
                    <button type="button" class="btn btn-default btn-sm"
                            onclick="location.href='?section=catalog&action=edit&id=<?= $item['id'] ?>'">
                        Edit
                    </button>
                    <a href="?section=catalog&action=delete&id=<?= $item['id'] ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Вы уверены?');">
                        Delete</a>
                </td>
            </tr>
            <?php
            $children = GetCatalogList($item['id']);
            if (!$children) continue;
            foreach ($children as $child):
            ?>
                <tr>
                    <td style="padding-left: 20px">
                        <?= $child['name'] ?>
                    </td>
                    <td class="text-right">
                        <button type="button" class="btn btn-default btn-sm"
                                onclick="location.href='?section=catalog&action=edit&id=<?= $child['id'] ?>'">
                            Edit
                        </button>
                        <a href="?section=catalog&action=delete&id=<?= $child['id'] ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Вы уверены?');">
                            Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </table>
</div>

