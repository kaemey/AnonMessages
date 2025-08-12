<?php

$config = include 'config.php';
$salt = $config['security']['ip_hash_salt'];
$user_ip = hash('sha256', $_SERVER['REMOTE_ADDR'] . $salt);
$now = time();
$limit_seconds = 60;

$isOftenSend = false;

// Проверяем последние отправки от этого IP
$stmt = $db->prepare("SELECT created_at FROM submissions WHERE ip = :ip");
$stmt->execute(['ip' => $user_ip]);
$lastSubmission = $stmt->fetch(PDO::FETCH_ASSOC);

if ($lastSubmission) {
    $lastTime = strtotime($lastSubmission['created_at']);
    if (($now - $lastTime) < $limit_seconds) {
        // Слишком часто, отправляем ошибку
        $isOftenSend = true;
    }
}

return $isOftenSend;