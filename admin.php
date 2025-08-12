<?php
include 'core/admin.php';
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Админка</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="public/ph-theme.css" rel="stylesheet">
</head>

<body>

    <?php if (!isset($_SESSION['admin'])): ?>
        <div class="centered-form">
            <div class="form-card">
                <h4 class="mb-4 text-center">Вход в админку</h4>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Логин</label>
                        <input type="text" name="login" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Пароль</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <input type="hidden" name="csrf_token" value="<?= getCSRFToken() ?>">
                    <button type="submit" class="btn btn-primary w-100">Войти</button>
                </form>
                <br>
                <a href="/"><button class="btn btn-primary w-100">Написать сообщение</button></a>
            </div>
        </div>
    <?php else: ?>
        <!-- Верхняя панель -->
        <nav class="navbar navbar-expand-lg mb-4">
            <div class="container">
                <a class="navbar-brand" href="/admin">Админка</a>
                <div class="ms-auto d-flex gap-2">
                    <a class="btn btn-primary btn-sm" href="/">✉️ Написать</a>

                    <a class="btn btn-warning btn-sm" href="/admin?<?= $showDeleted ? '' : 'show_deleted=1' ?>">
                        <?= $showDeleted ? '🙈 Скрыть удалённые' : '🗑️ Показать удалённые' ?>
                    </a>

                    <a class="btn btn-danger btn-sm" href="/admin?logout=1">🚪 Выйти</a>
                </div>
            </div>
        </nav>

        <div class="messages-card">
            <h4 class="mb-3"><?= $showDeleted ? 'Удалённые сообщения' : 'Сообщения' ?></h4>
            <ul class="list-group">
                <?php if (empty($messages)): ?>
                    <li class="list-group-item">Нет сообщений.</li>
                <?php else: ?>
                    <?php foreach ($messages as $msg): ?>
                        <li
                            class="list-group-item d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center">
                            <div class="me-3 mb-2 mb-sm-0">
                                <strong>#<?= $msg['id'] ?>:</strong> <?= htmlspecialchars($msg['content']) ?>
                            </div>
                            <div>
                                <?php if (!$showDeleted): ?>
                                    <a href="?delete=<?= $msg['id'] ?>" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Пометить как удалённое?');">Удалить</a>
                                <?php else: ?>
                                    <a href="?restore=<?= $msg['id'] ?>" class="btn btn-sm btn-success"
                                        onclick="return confirm('Восстановить сообщение?');">Восстановить</a>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>

    <?php endif; ?>

</body>

</html>