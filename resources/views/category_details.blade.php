<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Просмотр категории | ShopManager</title>
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
            <h2>Категория: {{ $category->name }}</h2>
            <div class="action-btns">
                <a class="btn-secondary" href="/admin/categories">← К списку</a>
                <a class="btn-primary" href="/admin/categories/{{ $category->id }}/edit">✏️ Редактировать</a>
            </div>
        </div>

        <table class="data-table" aria-label="Информация о категории">
            <tbody>
            <tr><th style="width:220px; background:#f9fafb;">ID</th><td>{{ $category->id }}</td></tr>
            <tr><th style="background:#f9fafb;">Название</th><td>{{ $category->name }}</td></tr>
            <tr><th style="background:#f9fafb;">Описание</th><td>{{ $category->description ?? 'Нет описания' }}</td></tr>
            <tr><th style="background:#f9fafb;">Кол-во товаров</th><td><span class="badge">{{ $category->products->count() }}</span></td></tr>
            </tbody>
        </table>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>Товары в категории</h2>
            <a class="btn-primary" href="/admin/categories/{{ $category->id }}/products/create">➕ Новый товар</a>
        </div>

        <table class="data-table">
            <thead><tr><th>ID</th><th>Название</th><th>Цена</th><th>Действия</th></tr></thead>
            <tbody>
            @foreach($category->products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td class="action-btns">
                        <a class="btn-secondary" href="/admin/products/{{ $product->id }}">👁️</a>
                        <a class="btn-secondary" href="/admin/products/{{ $product->id }}/edit">✏️</a>

                        <form action="/admin/products/{{ $product->id }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" style="border:none; cursor:pointer;" onclick="return confirm('Удалить товар?')">🗑️</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>