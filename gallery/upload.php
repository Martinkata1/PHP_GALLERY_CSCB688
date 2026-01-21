<?php
require __DIR__ . '/config/db.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/auth.php';


$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($title === '') {
        $errors[] = 'Заглавието е задължително.';
    }

    //Провериваме дали снимката е избрана
    if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Моля изберете снимка.';
    } else {
        $file = $_FILES['photo'];

        //Приети формати
        $allowed = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif'
        ];

        //Детект МИМЕ тип
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);

        if (!array_key_exists($mime, $allowed)) {
            $errors[] = 'Допустими формати: JPG, PNG, GIF.';
        }

        //Максимален размер 5MB
        $maxBytes = 5 * 1024 * 1024;
        if ($file['size'] > $maxBytes) {
            $errors[] = 'Максимален размер: 5 MB.';
        }
    }

    //Ако няма проблем, ъплоад и инсерт в бази данни
    if (empty($errors)) {
        $ext = $allowed[$mime];
        $base = bin2hex(random_bytes(8));
        $filename = $base . '.' . $ext;

        $dest = __DIR__ . '/uploads/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            $errors[] = 'Грешка при запис на файла.';
        } else {
            //Запази информацията в бази данни
            $sql = 'INSERT INTO photos (title, description, filename)
                    VALUES (:title, :description, :filename)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':title' => $title,
                ':description' => $description,
                ':filename' => $filename
            ]);

            $success = true;
        }
    }
}
?>

<h1 class="mb-4">Качи снимка</h1>

<?php if ($success): ?>
    <div class="alert alert-success">
        Снимката беше качена успешно. <a href="/">Върни се в галерията</a>
    </div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger"><ul>
        <?php foreach ($errors as $e): ?>
            <li><?= h($e) ?></li>
        <?php endforeach; ?>
    </ul></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Заглавие</label>
        <input type="text" name="title" class="form-control"
               value="<?= isset($title) ? h($title) : '' ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Описание</label>
        <textarea name="description" class="form-control"><?= isset($description) ? h($description) : '' ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Снимка</label>
        <input type="file" name="photo" class="form-control" accept="image/*">
        <div class="form-text">JPG, PNG, GIF — максимум 5 MB.</div>
    </div>

    <button class="btn btn-primary">Качи</button>
</form>

<?php require __DIR__ . '/includes/footer.php'; ?>