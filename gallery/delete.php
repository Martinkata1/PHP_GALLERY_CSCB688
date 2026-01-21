<?php
require __DIR__ . '/auth.php';
require __DIR__ . '/config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);

    //Вземи името на файла от базата
    $stmt = $pdo->prepare("SELECT filename FROM photos WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $photo = $stmt->fetch();

    if ($photo) {
        $filePath = __DIR__ . '/uploads/' . $photo['filename'];

        //Изтрий файла, ако съществува
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        //Изтрий записа от базата
        $stmt = $pdo->prepare("DELETE FROM photos WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}

header('Location: index.php');
exit;
