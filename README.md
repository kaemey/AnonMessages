# 📬 Анонимная система сообщений

![PHP](https://img.shields.io/badge/PHP-7.4%2B-blue?logo=php&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple?logo=bootstrap&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-3.0-blue?logo=sqlite&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green)

> Простое и безопасное веб-приложение для отправки **анонимных сообщений** с удобной админкой для модерации.

---

## ✨ Возможности

- 📩 **Отправка сообщений** без регистрации.
- 🛡 **Защита от спама** — ограничение по времени для одного IP.
- 🔑 **Авторизация в админку** по логину и паролю.
- 🚫 **Антибот-фильтр** (honeypot-поле + задержка отправки).
- 🗑 **Мягкое удаление сообщений** с возможностью восстановления.
- 📱 **Адаптивный дизайн** (Bootstrap 5).
- 🗄 **SQLite** — не нужен отдельный сервер базы данных.
- 🔒 **Хеширование IP** с солью для конфиденциальности.

---

## 📂 Структура проекта
```
/core
db.php # Подключение к базе данных
main.php # Логика обработки формы
admin.php # Логика админки
csrf.php # CSRF-защита

/public
ph-theme.css # Стили оформления

index.php # Форма отправки сообщений
admin.php # Панель администратора
config.php # Конфигурация проекта
.htaccess # Настройки Apache
```
## 🚀 Установка

1. **Клонировать репозиторий**
   ```bash
   git clone https://github.com/username/repo-name.git
   cd repo-name
    ```
2. **Настроить конфигурацию в config.php**
    ```php
    return [
        'admin' => [
            'login' => 'admin',
            'password' => 'secret'
        ],
        'security' => [
            'ip_hash_salt' => 'уникальная_строка'
        ]
    ];
    ```
3. **Дать права на запись базе SQLite**
    ```
    chmod 777 database.sqlite
    ```
- 🔒 Защита от спама
- ⏳ Ограничение отправки — 1 сообщение в 60 секунд.
- 🕵 Honeypot-поле (phone_number) для отсева ботов.
- 🔐 IP хешируется через sha256 + соль.

## 📝 Лицензия
MIT License — можно использовать и изменять свободно.

## 💡 Если проект понравился, поставьте ⭐ на GitHub, чтобы его поддержать!
