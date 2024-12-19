<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать профиль</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>
<body>
    <h1>Редактировать профиль</h1>
    <form id="editProfileForm" method="POST" action="{{ route('profile.update') }}">
        @csrf
        <label for="weight">Вес (кг):</label>
        <input type="number" id="weight" name="weight" value="{{ old('weight', $user->weight ?? '') }}" required>

        <!-- Можно добавить другие поля для редактирования -->

        <button type="submit">Сохранить изменения</button>
    </form>

    <button id="cancelButton" onclick="window.location.href='{{ route('profile.show') }}'">Отмена</button>

    <script src="{{ asset('js/edit_profile.js') }}"></script>

    <!-- Нижняя панель навигации -->
    <nav class="bottom-nav">
        <a href="{{ route('profile.show') }}" class="nav-link">Профиль</a>
        <a href="{{ route('training.index') }}" class="nav-link">Тренировка</a>
        <a href="{{ route('shop.index') }}" class="nav-link">Магазин</a>
    </nav>
</body>
</html>
