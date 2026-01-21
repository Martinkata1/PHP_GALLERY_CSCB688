<?php
require __DIR__ . '/config/db.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/auth.php';



$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
echo '<div class="alert alert-danger">Невалидно id.</div>';
require __DIR__ . '/includes/footer.php';
exit;
}


$stmt = $pdo->prepare('SELECT * FROM photos WHERE id = :id LIMIT 1');
$stmt->execute([':id' => $id]);
$photo = $stmt->fetch();


if (!$photo) {
echo '<div class="alert alert-danger">Снимката не е намерена.</div>';
require __DIR__ . '/includes/footer.php';
exit;
}
?>


<div class="row">
<div class="col-md-8">
<img src="uploads/<?php echo h($photo['filename']); ?>" alt="<?php echo h($photo['title']); ?>" class="img-fluid">
</div>
<div class="col-md-4">
    <h2><?php echo h($photo['title']); ?></h2>
    <p class="text-muted">Качена: <?php echo h($photo['uploaded_at']); ?></p>
    <?php if ($photo['description']): ?>
        <p><?php echo nl2br(h($photo['description'])); ?></p>
    <?php endif; ?>

    <a href="/" class="btn btn-secondary">Обратно към галерията</a>

    <!--Бутон за изтриване-->
    <form method="post" action="delete.php" style="margin-top:10px;" 
          onsubmit="return confirm('Сигурни ли сте, че искате да изтриете тази снимка?');">
        <input type="hidden" name="id" value="<?php echo $photo['id']; ?>">
        <button type="submit" class="btn btn-danger">Изтрий снимката</button>
    </form>
</div>
</div>


<?php require __DIR__ . '/includes/footer.php'; ?>