<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Просмотр товара | ShopManager</title>
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
        <a class="tab-btn" href="/admin/categories">📂 Категории</a>
        <a class="tab-btn active" href="/admin/products">🏷️ Товары</a>
        <a class="tab-btn" href="/admin/orders">📦 Заказы</a>
    </nav>

    <div class="card">
        <div class="card-header">
            <h2>Товар: {{ $product->name }}</h2>
            <div class="action-btns">
                <a class="btn-secondary" href="/admin/products">← К списку</a>
                <a class="btn-primary" href="/admin/products/{{ $product->id }}/edit">✏️ Редактировать</a>
            </div>
        </div>

        <table class="data-table" aria-label="Информация о товаре">
            <tbody>
            <tr><th style="width:220px; background:#f9fafb;">ID</th><td>{{ $product->id }}</td></tr>
            <tr><th style="background:#f9fafb;">Название</th><td>{{ $product->name }}</td></tr>
            <tr><th style="background:#f9fafb;">Описание</th><td>{{ $product->description ?? 'Нет описания' }}</td></tr>
            <tr><th style="background:#f9fafb;">Цена</th><td>{{ number_format($product->price, 2, '.', '') }}</td></tr>
            <tr>
                <th style="background:#f9fafb;">Категория</th>
                <td>
                    {{ $product->category ? $product->category->name : 'Без категории' }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>Изображения</h2>
            <span class="badge">Всего: {{ $product->images->count() + 1 }}</span>
        </div>
        <div class="image-preview-grid">
            <div style="text-align: center;">
                <img class="thumb-img" alt="Главное изображение" src="{{ asset($product->default_img) }}">
                <p style="font-size: 10px; color: #6c757d;">Главное</p>
            </div>

            @foreach($product->images as $img)
                <div style="text-align: center;">
                    <img class="thumb-img" alt="Доп. изображение" src="{{ asset($img->path) }}">
                </div>
            @endforeach
        </div>
        <div style="font-size:12px; margin-top:12px; color:#6c757d;">
            * В backend-версии: водяной знак "Shop" и миниатюры 300x300
        </div>
    </div>
</div>
</body>
</html>