<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Магазин</title>
    @vite(['resources/css/shop.css', 'resources/js/shop.js'])
    <!-- Подключение стилей через Laravel Mix -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
    <!-- Подключение шрифта INTRO -->
    <style>
        @font-face {
            font-family: 'INTRO';
            src: url('{{ asset('fonts/INTRO.ttf') }}') format('truetype');
        }
        body {
            font-family: 'INTRO', sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
        }
    </style>
</head>
<body>
    <!-- Фоновое изображение -->
    <div class="background-container">
        <img src="{{ asset('images/shop.webp') }}" alt="Магазин" class="background-image">
        <div class="overlay">
            <img src="{{ asset('images/icons/lock.png') }}" alt="Замок" class="lock-icon">
            <div class="coming-soon-text">СКОРО</div>
        </div>
    </div>

    <!-- Нижняя панель навигации -->
    <nav class="bottom-nav">
        <a href="{{ url('/shop') }}" class="nav-link active">
            <img src="{{ asset('images/icons/shop.png') }}" alt="Магазин">
            <span>МАГАЗИН</span>
        </a>
        <a href="{{ url('/training') }}" class="nav-link">
            <img src="{{ asset('images/icons/training.png') }}" alt="Тренировка">
            <span>ТРЕНИРОВКА</span>
        </a>
        <a href="{{ url('/profile') }}" class="nav-link">
            <img src="{{ asset('images/icons/profile.png') }}" alt="Профиль">
            <span>ПРОФИЛЬ</span>
        </a>
    </nav>
</body>
</html>
