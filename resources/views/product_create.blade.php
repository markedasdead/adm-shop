<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание товара | ShopManager</title>
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
            <h2>Создать товар</h2>
            <a class="btn-secondary" href="/admin/products">← К списку</a>
        </div>

        <form action="/admin/products" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="productName">Название (обяз., макс 20)</label>
                <input id="productName" name="name" type="text" maxlength="20" required value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label for="productDesc">Описание (макс 50)</label>
                <textarea id="productDesc" name="description" rows="2" maxlength="50">{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
                <label for="productPrice">Цена (больше 10, формат xx.xx)</label>
                <input id="productPrice" name="price" type="text" placeholder="99.99" required value="{{ old('price') }}">
            </div>
            <div class="form-group">
                <label for="productCategory">Категория</label>
                <select id="productCategory" name="category_id" required>
                    <option value="" selected disabled>Выберите категорию</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="productImages">Изображения (макс 5, jpg/png, минимум 1 при создании)</label>
                <input type="file" id="productImages" name="images[]" multiple accept="image/jpeg,image/png" required>
            </div>
            <div class="form-group">
                <label for="defaultImgSelect">Изображение по умолчанию</label>
                <select id="defaultImgSelect" name="default_image">
                    <option value="" selected>— будет выбрано на сервере —</option>
                </select>
            </div>

            @if ($errors->any())
                <div style="color: red; margin-bottom: 15px; font-size: 14px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="action-btns" style="justify-content:flex-end;">
                <a class="btn-secondary" href="/admin/products">Отмена</a>
                <button type="submit" class="btn-primary">Сохранить товар</button>
            </div>
        </form>

        <div style="font-size:12px; margin-top:12px; color:#6c757d;">
            * В backend-версии: проверки формата/размера и генерация миниатюр/водяного знака
        </div>
    </div>
</div>
</body>
</html>