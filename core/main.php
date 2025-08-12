<?php
$db = include 'core/db.php';
include 'core/csrf.php';

$isOftenSend = false;
$csrfError = false;

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Проверка на робота, заполняющего все поля
    if (!empty($_POST['phone_number'])) {
        die();
    }

    // Проверка CSRF токена
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!verifyCSRFToken($csrfToken)) {
        $csrfError = true;
    } else {
        $isOftenSend = include 'core/checkip.php';

        if (!$isOftenSend) {

            if ($lastSubmission) {
                $stmt = $db->prepare("UPDATE submissions SET created_at = CURRENT_TIMESTAMP WHERE ip = :ip");
                $stmt->bindParam(':ip', $user_ip);
                $stmt->execute();
            } else {
                $stmt = $db->prepare("INSERT INTO submissions (ip, created_at) VALUES (:ip, CURRENT_TIMESTAMP)");
                $stmt->bindParam(':ip', $user_ip);
                $stmt->execute();
            }

            $message = $_POST['message'] ?? '';
            if (!empty(trim($message))) {
                $stmt = $db->prepare("INSERT INTO messages (content) VALUES (:message)");
                $stmt->bindParam(':message', $message);
                $stmt->execute();
            }
            header("Location: /?success=1");
            exit;
        }
    }
}