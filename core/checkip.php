<?php

$config = include 'config.php';
$salt = $config['security']['ip_hash_salt'];
$user_real_ip = getUserIP();
$user_ip = hash('sha256', $user_real_ip . $salt);
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

function getUserIP()
{
    if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        // Cloudflare
        return $_SERVER['HTTP_CF_CONNECTING_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // Прокси/балансировщики, берём первый IP
        return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    } elseif (!empty($_SERVER['HTTP_X_REAL_IP'])) {
        // Nginx reverse proxy
        return $_SERVER['HTTP_X_REAL_IP'];
    } else {
        // По умолчанию
        return $_SERVER['REMOTE_ADDR'];
    }
}

return $isOftenSend;