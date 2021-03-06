<?php
require_once('./models/goods.php');
require_once('./models/catalog.php');

$action = getAction();
switch ($action) {
    case 'show':
        render('goods', 'list', $_GET); // $_GET - чтобы подцепилось автоматически category_id
        break;
    case 'new':
        render('goods', 'new', $_GET);
        break;
    case 'edit':
        render('goods', 'edit', $_GET);
        break;
    case 'add':
        $errors = ValidateProductItemForm($_POST);
        if ($errors) {
            render('goods', 'new', ['errors' => $errors]);
        } else {
            $id = AddProductItem($_POST['name'], $_POST['description'], $_POST['category_id'], $_POST['price'], $_POST['amount']);
            if ($_FILES && isset($_FILES['img']['size']) && $_FILES['img']['size']) {
                $img = process_image($id, $error);
                if ($error) {
                    $_GET['id'] = $id; // это нужно для передачи внутрь следующей формы
                    render('goods', 'update', ['errors' => ['Ошибка при загрузке картинки']]);
                    exit();
                } else {
                    AddImageToProductItem($id, $img);
                }
            }
            header('Location: ?section=goods&category_id=' . $_POST['category_id']);
        }
        break;
    case 'update':
        $errors = ValidateProductItemForm($_POST);
        if ($errors) {
            render('goods', 'edit', ['errors' => $errors]);
        } else {
            EditProductItem(getId(), $_POST['name'], $_POST['description'], $_POST['category_id'], $_POST['price'], $_POST['amount']);
            if ($_FILES && isset($_FILES['img']['size']) && $_FILES['img']['size']) {
                $img = process_image(getId(), $error);
                if ($error) {
                    render('goods', 'edit', ['errors' => ['Ошибка при загрузке картинки']]);
                    exit();
                } else {
                    AddImageToProductItem(getId(), $img);
                }
            }
            render('goods', 'edit', ['message' => 'Изменения сохранены']);
        }
        break;
    case 'delete':
        $item = GetProductItem(getId());
        DeleteProductItem(getId());
        header('Location: ?section=goods&category_id=' . $item['parent_id']);
        break;
    case 'delete-img':
        $item = GetProductItem(getId());
        DeleteImageFromProductItem(getId());
        header('Location: ?section=goods&category_id=' . $item['parent_id']);
        break;
    default:
        print 'Это действие я еще обрабатывать не умею :(';
        break;
}

function print_catalog($parent_id = 0, $selected = 0)
{
    $items = GetCatalogList($parent_id);
    foreach ($items as $item) {
        $active = '';
        $level = $parent_id ? '..... ' : '';
        if ($item['id'] == $selected) {
            $active = 'selected="selected"';
        }
        print '<option value="' . $item['id'] . '" ' . $active . '>' . $level . $item['name'] . '</option>';

        if ($children = GetCatalogList($item['id'])) {
            print_catalog($item['id'], $selected);
        }
    }
}

function process_image($productId, &$error = '')
{
    try {
        if (
            !isset($_FILES['img']['error']) ||
            is_array($_FILES['img']['error'])
        ) {
            throw new RuntimeException('Invalid parameters.');
        }

        switch ($_FILES['img']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException('No file sent.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException('Exceeded filesize limit.');
            default:
                throw new RuntimeException('Unknown errors.');
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search(
                $finfo->file($_FILES['img']['tmp_name']),
                array(
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                ),
                true
            )
        ) {
            throw new RuntimeException('Invalid file format.');
        }

        $file_name = sprintf('%s.%s', $productId . '-image', $ext);
        if (!move_uploaded_file($_FILES['img']['tmp_name'], ImgPath() . $file_name)) {
            throw new RuntimeException('Failed to move uploaded file.');
        }

        return $file_name;
    } catch (RuntimeException $e) {
        $error = $e->getMessage();
        return false;
    }
}