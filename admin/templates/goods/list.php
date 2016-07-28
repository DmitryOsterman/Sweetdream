<?php
if (!isset($category_id)) {
    $categories = GetCatalogList();
    $item = current($categories);
    $category_id = $item['id'];
}
$items = GetProductList($category_id);
?>
<div class="page-header">
    <h4>Продукция</h4>
    <form class="form-inline">
        <select onchange="location.href='?section=goods&category_id='+this.value" class="form-control">
            <?php print_catalog(0, $category_id) ?>
        </select>
    </form>
</div>
<div class="col-xs-12">
    <button class="btn btn-primary" onclick="location.href='?section=goods&action=new&category_id=<?= $category_id ?>'">
        Добавить
    </button>
    <p></p>
    <table class="table table-striped">
        <tr>
            <th>Id</th>
            <th>Название</th>
            <th>Цена, руб</th>
            <th>Остаток</th>
            <th>Картинка</th>
            <th>Управление</th>
        </tr>
        <?php foreach ($items as $item): ?>
            <tr>
                <td>
                    <?= $item['id'] ?>
                </td>
                <td>
                    <?= $item['name'] ?>
                </td>
                <td>
                    <?= $item['price'] ?>
                </td>
                <td>
                    <?= $item['amount'] ?>
                </td>
                <td>
                    <?php if ($item['img_link']): ?>
                        <img src="<?= ImgUrl() . $item['img_link'] ?>" width="100">
                    <?php endif; ?>
                </td>
                <td class="text-right">
                    <button type="button" class="btn btn-default btn-sm"
                            onclick="location.href='?section=goods&action=edit&id=<?= $item['id'] ?>'">
                        Edit
                    </button>
                    <a href="?section=goods&action=delete&id=<?= $item['id'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Вы уверены?');">
                        Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>