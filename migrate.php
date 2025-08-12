<?php
include 'core/db.php';  // Подключение к базе

// Создание таблицы для отслеживания отправок по IP
$db->exec("CREATE TABLE IF NOT EXISTS submissions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    ip TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

echo "Миграция выполнена успешно!\n";
echo "Создана таблица submissions для защиты от спама.\n";