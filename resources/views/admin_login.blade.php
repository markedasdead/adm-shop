<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация | ShopManager</title>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
</head>
<body>

<div class="login-wrapper">
    <div class="login-header">
        <h2>🔐 Вход в админ-панель</h2>
        <p>Введите email и пароль</p>
    </div>

    <form action="/admin/login" method="POST">
        @csrf <div class="form-group">
            <label for="loginEmail">Email</label>
            <input type="email" id="loginEmail" name="email" placeholder="admin@shop.com" value="admin@shop.com" required>
        </div>

        <div class="form-group">
            <label for="loginPassword">Пароль</label>
            <input type="password" id="loginPassword" name="password" placeholder="пароль" required>
        </div>

        @if($errors->any())
            <div style="color: #dc3545; font-size: 14px; margin-bottom: 10px;">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="form-group">
            <button type="submit" class="btn-primary" style="width:100%">Войти</button>
        </div>

        <div style="font-size:12px; margin-top:20px; text-align:center; color:#6c757d;">
            Демо-данные по ТЗ: admin@shop.com / shop2015
        </div>
    </form>
</div>
</body>
</html>