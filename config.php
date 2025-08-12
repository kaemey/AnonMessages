<?php

// Конфигурация приложения
return [
    // Данные администратора
    'admin' => [
        'login' => 'admin',
        'password' => 'palatapalata', // В продакшене используйте сложный пароль
    ],

    // Данные для безопасности
    'security' => [
        'ip_hash_salt' => 'palatapalata', // Соль для хеша IP
    ],

    // Данные для базы данных
    'database' => [
        'path' => 'messages.db',
    ],
];

?>