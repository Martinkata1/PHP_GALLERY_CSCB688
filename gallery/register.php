<?php
require __DIR__ . '/config/db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Всички полета са задължителни';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare(
                "INSERT INTO users (username, password) VALUES (:u, :p)"
            );
            $stmt->execute([':u' => $username, ':p' => $hash]);
            header('Location: login.php');
            exit;
        } catch (PDOException $e) {
            $error = 'Потребителското име вече съществува';
        }
    }
}
?>

<!doctype html>
<html lang="bg">
<head>
<meta charset="utf-8">
<title>Регистрация</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width:400px;">
    <h2 class="mb-3 text-center">Регистрация</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <input class="form-control mb-3" name="username" placeholder="Потребителско име">
        <input class="form-control mb-3" type="password" name="password" placeholder="Парола">
        <button class="btn btn-success w-100">Регистрация</button>
    </form>

    <div class="text-center mt-3">
        <a href="login.php">Обратно към вход</a>
    </div>
</div>

</body>
</html>
