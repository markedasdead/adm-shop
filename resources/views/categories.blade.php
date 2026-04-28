<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Категории | ShopManager</title>
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

    <div class="panel">
        <div class="card">
            <div class="card-header">
                <h2>Список категорий</h2>
                <a href="/admin/categories/create" class="btn-primary">➕ Создать категорию</a>
            </div>

            <table class="data-table">
                <thead>
                <tr><th>ID</th><th>Название</th><th>Описание</th><th>Кол-во товаров</th><th>Действия</th></tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description ?? '—' }}</td>
                        <td>{{ $category->products_count ?? 0 }}</td>
                        <td class="action-btns">
                            <a class="btn-secondary" href="/admin/categories/{{ $category->id }}">👁️</a>
                            <a class="btn-secondary" href="/admin/categories/{{ $category->id }}/edit">✏️</a>

                            <form action="/admin/categories/{{ $category->id }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger" style="border:none; cursor:pointer;" onclick="return confirm('Удалить?')">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>