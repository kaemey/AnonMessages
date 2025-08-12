<?php
session_start();
$db = include 'core/db.php';
include 'core/csrf.php';

// Настройки
$config = include 'config.php';
$adminLogin = $config['admin']['login'];
$adminPassword = $config['admin']['password'];

// Выход
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: /admin');
    exit;
}

// Удаление (пометка)
if (isset($_SESSION['admin'], $_GET['delete']) && is_numeric($_GET['delete'])) {
    $stmt = $db->prepare("UPDATE messages SET is_deleted = 1 WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header('Location: /admin');
    exit;
}

// Восстановление сообщения
if (isset($_SESSION['admin'], $_GET['restore']) && is_numeric($_GET['restore'])) {
    $stmt = $db->prepare("UPDATE messages SET is_deleted = 0 WHERE id = ?");
    $stmt->execute([$_GET['restore']]);
    header('Location: /admin?show_deleted=1');
    exit;
}

// Вход
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    $csrfToken = $_POST['csrf_token'] ?? '';

    // Проверка CSRF токена
    if (!verifyCSRFToken($csrfToken)) {
        $error = 'Ошибка безопасности. Попробуйте еще раз.';
    } elseif ($login === $adminLogin && $password === $adminPassword) {
        $_SESSION['admin'] = true;
        header('Location: /admin');
        exit;
    } else {
        $error = 'Неверный логин или пароль.';
    }
}

// Показать удалённые
$showDeleted = isset($_GET['show_deleted']) ? true : false;

// Выборка сообщений
if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
    if ($showDeleted) {
        $messages = $db->query("SELECT id, content, is_deleted FROM messages WHERE is_deleted = 1 ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $messages = $db->query("SELECT id, content, is_deleted FROM messages WHERE is_deleted = 0 ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }
}