<?php
require __DIR__ . '/config/db.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/auth.php';



//Фетч всички снимки
$stmt = $pdo->query('SELECT id, title, filename, uploaded_at FROM photos ORDER BY uploaded_at DESC');
$photos = $stmt->fetchAll();
?>


<h1 class="mb-4">Галерия</h1>


<?php if (empty($photos)): ?>
<div class="alert alert-info">Все още няма качени снимки. <a href="upload.php">Качете първата снимка</a>.</div>
<?php else: ?>
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
<?php foreach ($photos as $p): ?>
<div class="col">
<div class="card h-100">
<a href="view.php?id=<?php echo $p['id']; ?>">
<img src="uploads/<?php echo h($p['filename']); ?>" class="card-img-top thumb" alt="<?php echo h($p['title']); ?>">
</a>
<div class="card-body">
<h5 class="card-title"><?php echo h($p['title']); ?></h5>
<p class="card-text"><small class="text-muted">Качена: <?php echo h($p['uploaded_at']); ?></small></p>
</div>
</div>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>


<?php require __DIR__ . '/includes/footer.php'; ?>