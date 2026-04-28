<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказы | ShopManager</title>
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
        <a class="tab-btn" href="/admin/products">🏷️ Товары</a>
        <a class="tab-btn active" href="/admin/orders">📦 Заказы</a>
    </nav>

    <div class="panel">
        <div class="card">
            <div class="card-header">
                <h2>Список заказов</h2>
            </div>

            <table class="data-table">
                <thead><tr><th>Товар</th><th>Email пользователя</th><th>Цена</th><th>Статус</th></tr></thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>
                            <a href="/admin/products/{{ $order->product_id }}">
                                {{ $order->product_name ?? 'Товар #' . $order->product_id }}
                            </a>
                        </td>
                        <td>{{ $order->user_email ?? 'guest@example.com' }}</td>
                        <td>{{ $order->price }}</td>
                        <td>
                                <span class="status-{{ $order->status_class ?? 'pending' }}">
                                    {{ $order->status_text ?? $order->status }}
                                </span>
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