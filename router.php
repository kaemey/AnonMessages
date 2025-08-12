<?php
// router.php
$request = $_SERVER['REQUEST_URI'];

if (str_starts_with($request, '/admin')) {
    require 'admin.php';
} elseif (file_exists(__DIR__ . $request)) {
    return false; // Отдаём статику (CSS, изображения и т.п.)
} else {
    require 'index.php';
}