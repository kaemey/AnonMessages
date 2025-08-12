<?php

include 'core/main.php';

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Оставить сообщение</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="public/ph-theme.css" rel="stylesheet">
</head>

<body>
    <div class="centered-form">
        <div class="form-card">
            <h4 class="mb-4 text-center">Анонимное сообщение</h4>

            <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                    ✅ Сообщение успешно отправлено!
                </div>
            <?php endif; ?>

            <?php if ($isOftenSend): ?>
                <div class="alert alert-danger" role="alert">
                    🚫 Слишком часто отправляете сообщения. Можно лишь раз в минуту.
                </div>
            <?php endif; ?>

            <?php if ($csrfError): ?>
                <div class="alert alert-danger" role="alert">
                    🚫 Ошибка безопасности. Попробуйте еще раз.
                </div>
            <?php endif; ?>

            <form method="POST">
                <textarea name="message" class="form-control mb-3" rows="4" placeholder="Введите сообщение..."
                    <?= ($isOftenSend) ? 'disabled' : 'required' ?>></textarea>
                <input type="text" name="phone_number" style="display:none" <?= ($isOftenSend) ? 'disabled' : '' ?>>
                <input type="hidden" name="csrf_token" value="<?= getCSRFToken() ?>">
                <button type="submit" class="btn btn-primary w-100" <?= ($isOftenSend) ? 'disabled' : '' ?>>
                    Отправить
                </button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const alertBox = document.getElementById('successAlert');
            if (alertBox) {
                setTimeout(() => {
                    window.location.href = "/";
                }, 1500);
            }

            <?php if ($isOftenSend): ?>
                setTimeout(() => {
                    window.location.href = "/";
                }, 3000); // 3 секунды
            <?php endif; ?>
        });
    </script>
</body>

</html>