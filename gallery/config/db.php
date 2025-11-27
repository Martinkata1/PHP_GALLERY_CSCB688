<?php
$DB_HOST = '127.0.0.1';
$DB_NAME = 'gallery_db';
$DB_USER = 'root';
$DB_PASS = 'M200311k';
$DB_DSN = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4";


$options = [
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
PDO::ATTR_EMULATE_PREPARES => false,
];


try {
$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS, $options);
   //Тест за връзка
    //echo "Connection successful!<br>";
    
    // Проверка коя база е свързана
    $stmt = $pdo->query("SELECT DATABASE()");
    //echo "Connected to database: " . $stmt->fetchColumn();
 
} catch (PDOException $e) {
// In production, do not show full error message
die('Database connection failed: ' . $e->getMessage());
}