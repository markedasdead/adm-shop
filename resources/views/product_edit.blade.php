<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование товара | ShopManager</title>
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
            <h2>Редактировать товар</h2>
            <a class="btn-secondary" href="/admin/products/{{ $product->id }}">← К просмотру</a>
        </div>

        <form action="/admin/products/{{ $product->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="productName">Название (обяз., макс 20)</label>
                <input id="productName" name="name" type="text" maxlength="20" value="{{ old('name', $product->name) }}" required>
            </div>
            <div class="form-group">
                <label for="productDesc">Описание (макс 50)</label>
                <textarea id="productDesc" name="description" rows="2" maxlength="50">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="form-group">
                <label for="productPrice">Цена (больше 10, формат xx.xx)</label>
                <input id="productPrice" name="price" type="text" placeholder="99.99" value="{{ old('price', $product->price) }}" required>
            </div>
            <div class="form-group">
                <label for="productCategory">Категория</label>
                <select id="productCategory" name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="productImages">Заменить/добавить изображения (макс 5, jpg/png)</label>
                <input type="file" id="productImages" name="images[]" multiple accept="image/jpeg,image/png">
            </div>

            <div class="form-group">
                <label>Текущие изображения</label>
                <div class="image-preview-grid">
                    <div style="text-align: center;">
                        <img class="thumb-img" src="{{ asset($product->default_img) }}" alt="Главное">
                        <p style="font-size: 10px; color: #6c757d;">Главное</p>
                    </div>
                    @foreach($product->images as $img)
                        <img class="thumb-img" src="{{ asset($img->path) }}" alt="Доп. фото">
                    @endforeach
                </div>
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
                <a class="btn-secondary" href="/admin/products/{{ $product->id }}">Отмена</a>
                <button type="submit" class="btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>