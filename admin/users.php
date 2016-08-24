<?php
require_once('./models/users.php');
require_once('./models/catalog.php');

$action = getAction();
switch ($action) {
    case 'show':
        render('users', 'list');
        break;
    case 'new':
        render('users', 'new');
        break;
    case 'edit':
        render('users', 'edit');
        break;
    case 'add':
        $errors = ValidateUserItemAdmin($_POST);
        if ($errors) {
            render('users', 'new', ['errors' => $errors]);
        } else {
            //проверка - уникальности по e-mail
            if (FindUserItem(['email' => $_POST['email']])) {
                render('users', 'new', ['errors' => ['Человек с таким email уже зарегистрирован']]);
            } else {
                AddUserItem($_POST['first_name'], $_POST['second_name'],
                    $_POST['address'], $_POST['zip_code'],
                    $_POST['phone'], $_POST['email'],
                    md5($_POST['password']));
                render('users', 'new', ['message' => 'Изменения сохранены']);
                locationDelay("?section=users", 2000);
            }
        }
        break;


//        header('Location: ?section=goods&category_id=' . $_POST['category_id']);

    case 'update':
        $errors = ValidateUserItem($_POST);
        if ($errors) {
            render('users', 'edit', ['errors' => $errors]);
        } else {
            EditUserItem(getId(), $_POST['first_name'], $_POST['second_name'],
                $_POST['address'], $_POST['zip_code'],
                $_POST['phone'], $_POST['email'],
                md5($_POST['password']));
            render('users', 'edit', ['message' => 'Изменения сохранены']);
            locationDelay("?section=users", 9000);
        }
        break;
    case 'delete':
        $item = GetUserItem(getId());
        DeleteUserItem(getId());
        header('Location: ?section=users');
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

/*
function resize_image($img, &$error = '')
{
    $toWidth = 350;
    $toHeight = 350;

    $info = getimagesize($img);
    $width = $info[0];
    $height = $info[1];
    switch ($info[2]) {
        case 1:
            if (!($image = imagecreatefromgif($img))) {
                $error = 'Invalid image gif format';
                return false;
            }
            break;
        case 2:
            if ($image = imagecreatefromjpeg($img)) {
                $error = 'Invalid image jpeg format';
                return false;
            }
            break;
        case 3:
            if (!($image = imagecreatefrompng($img))) {
                $error = 'Invalid image png format';
                return false;
            }
            break;
        default:
            $error = 'Not supported image format';
            return false;
    }

    $newHeight = $toHeight;
    $newWidth = round($newHeight / $height * $width);

    if ($newWidth > $toWidth) {
        $newWidth = $toWidth;
        $newHeight = round($newWidth / $width * $height);
    }

    $newImage = imagecreatetruecolor($newWidth, $newHeight);

    switch ($this->format) {
        case 1: // gif
            $color = imagecolorallocate(
                $newImage,
                $this->transparencyColor[0],
                $this->transparencyColor[1],
                $this->transparencyColor[2]
            );

            imagecolortransparent($newImage, $color);
            imagetruecolortopalette($newImage, false, 256);
            break;
        case 3: // png
            imagealphablending($newImage, false);

            $color = imagecolorallocatealpha(
                $newImage,
                $this->transparencyColor[0],
                $this->transparencyColor[1],
                $this->transparencyColor[2],
                0
            );

            imagefill($newImage, 0, 0, $color);
            imagesavealpha($newImage, true);
            break;
    }

    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    imagedestroy($image);

    return true;
}
*/