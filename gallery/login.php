<?php
require __DIR__ . '/config/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // ✅ ВАЛИДАЦИЯ
    if ($username === '' || $password === '') {
        $error = 'Моля попълнете всички полета';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :u LIMIT 1");
        $stmt->execute([':u' => $username]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            $error = 'Грешно потребителско име или парола';
        } else {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: index.php');
            exit;
        }
    }
}
?>
<!doctype html>
<html lang="bg">
<head>
<meta charset="utf-8">
<title>Вход</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width:400px;">
    <h2 class="mb-3 text-center">Вход</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <input class="form-control mb-3" name="username" placeholder="Потребителско име">
        <input class="form-control mb-3" type="password" name="password" placeholder="Парола">
        <button class="btn btn-primary w-100">Вход</button>
    </form>

    <div class="text-center mt-3">
        <a href="register.php">Регистрация</a>
    </div>
</div>

</body>
</html>
