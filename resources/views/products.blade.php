<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Товары | ShopManager</title>
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

    <div class="panel">
        <div class="card">
            <div class="card-header">
                <h2>Список товаров</h2>
                <a class="btn-primary" href="/admin/categories">➕ К категориям для создания</a>
            </div>

            <table class="data-table">
                <thead><tr><th>Изобр.</th><th>Название</th><th>Цена</th><th>Действия</th></tr></thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>
                            <img src="{{ asset($product->default_img) }}" alt="{{ $product->name }}" width="50" class="thumb-img">
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product->price, 2, '.', '') }}</td>
                        <td class="action-btns" style="vertical-align: middle;">
                            <a class="btn-secondary" href="/admin/products/{{ $product->id }}">👁️</a>
                            <a class="btn-secondary" href="/admin/products/{{ $product->id }}/edit">✏️</a>
                            <form action="/admin/products/{{ $product->id }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger" style="border:none; background:none; cursor:pointer;">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="pagination" style="margin-top: 20px;">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
</body>
</html>