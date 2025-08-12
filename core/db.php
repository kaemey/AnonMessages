<?php
$config = include 'config.php';
// Создаёт базу данных и таблицу при первом запуске
$db = new PDO('sqlite:' . $config['database']['path']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db->exec("CREATE TABLE IF NOT EXISTS messages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    content TEXT NOT NULL,
    is_deleted INTEGER DEFAULT 0
)");

return $db;
?>