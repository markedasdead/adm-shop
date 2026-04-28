<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание категории | ShopManager</title>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
</head>
<body>
<div class="admin-container">
    <div class="header">
        <div class="logo"><h1>🛍️ ShopManager</h1></div>
        <div class="user-info">
            <span class="user-email">admin@shop.com</span>
            <form action="/admin/logout" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn" style="background:none; border:none; color:inherit; cursor:pointer;">
                    Выйти
                </button>
            </form>
        </div>
    </div>

    <nav class="nav-tabs" aria-label="Разделы админ-панели">
        <a class="tab-btn active" href="/admin/categories">📂 Категории</a>
        <a class="tab-btn" href="/admin/products">🏷️ Товары</a>
        <a class="tab-btn" href="/admin/orders">📦 Заказы</a>
    </nav>

    <div class="card">
        <div class="card-header">
            <h2>Создать категорию</h2>
            <a class="btn-secondary" href="/admin/categories">← К списку</a>
        </div>

        <form action="/admin/categories" method="POST">
            @csrf
            <div class="form-group">
                <label for="catName">Название (обяз., макс 15, кириллица, спецсимволы: пробел, тире)</label>
                <input type="text" id="catName" name="name" placeholder="Пример: Смартфоны" maxlength="15" required value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label for="catDesc">Описание (макс 50, кириллица, спецсимволы: пробел, тире, точка, запятая, : ;)</label>
                <textarea id="catDesc" name="description" rows="2" placeholder="Описание" maxlength="50">{{ old('description') }}</textarea>
            </div>

            @if ($errors->any())
                <div style="color: red; margin-bottom: 15px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="action-btns" style="justify-content:flex-end;">
                <a class="btn-secondary" href="/admin/categories">Отмена</a>
                <button type="submit" class="btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>