<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Упражнения</title>
    @vite(['resources/css/exercises.css', 'resources/js/exercises.js'])
    <!-- Подключение стилей -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/exercises.css') }}">
</head>
<body>
    <h1>Упражнения</h1>

    <!-- Форма для фильтрации по мышечным группам -->
    <form id="filterForm" method="GET" action="/exercises">
        <label for="muscleGroup">Выберите мышечную группу:</label>
        <select id="muscleGroup" name="muscleGroup">
            <option value="">Все</option>
            <option value="грудь" {{ request('muscleGroup') == 'грудь' ? 'selected' : '' }}>Грудь</option>
            <option value="спина" {{ request('muscleGroup') == 'спина' ? 'selected' : '' }}>Спина</option>
            <option value="ноги" {{ request('muscleGroup') == 'ноги' ? 'selected' : '' }}>Ноги</option>
            <option value="плечи" {{ request('muscleGroup') == 'плечи' ? 'selected' : '' }}>Плечи</option>
            <option value="бицепс" {{ request('muscleGroup') == 'бицепс' ? 'selected' : '' }}>Бицепс</option>
            <option value="трицепс" {{ request('muscleGroup') == 'трицепс' ? 'selected' : '' }}>Трицепс</option>
            <!-- Добавьте другие мышечные группы по необходимости -->
        </select>
        <button type="submit">Фильтровать</button>
    </form>

    <!-- Список упражнений -->
    <div id="exerciseList">
        <!-- Отображение упражнений через Laravel -->
        @if(isset($exercises) && $exercises->count())
            <ul>
                @foreach($exercises as $exercise)
                    <li>{{ $exercise->name }} ({{ $exercise->muscle_group }})</li>
                @endforeach
            </ul>
        @else
            <p>Упражнений не найдено.</p>
        @endif
    </div>

    <!-- Подключение скрипта -->
    <script src="{{ asset('js/exercises.js') }}"></script>

    <!-- Нижняя панель навигации -->
    <nav class="bottom-nav">
        <a href="/profile" class="nav-link">Профиль</a>
        <a href="/workouts" class="nav-link">Тренировка</a>
        <a href="/shop" class="nav-link">Магазин</a>
    </nav>
</body>
</html>
