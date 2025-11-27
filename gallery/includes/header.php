<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!doctype html>
<html lang="bg">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Галерия</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<style>
.thumb { height: 180px; object-fit: cover; width: 100%; }
.card-title { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
<div class="container">
<a class="navbar-brand" href="/">Галерия</a>
<div>
<a class="btn btn-sm btn-outline-primary" href="upload.php">Качи снимка</a>
</div>
</div>
</nav>
<div class="container"></div>