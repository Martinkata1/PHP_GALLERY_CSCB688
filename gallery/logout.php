<?php
session_start();

// Проверка дали потребителят е логнат
if (isset($_SESSION['user_id'])) {
    session_unset();
    session_destroy();
}

header('Location: login.php');
exit;
?>
