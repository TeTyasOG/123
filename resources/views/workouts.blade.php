<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>ИСТОРИЯ</title>
  <!-- Подключение стилей через Laravel Mix -->
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/workouts.css') }}">
  <style>
    @font-face {
      font-family: 'INTRO';
      src: url('{{ asset('fonts/INTRO.ttf') }}') format('truetype');
    }
    body {
      font-family: 'INTRO', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #ffffff;
    }
  </style>
</head>
<body>

  <!-- Верхняя панель -->
  <div class="top-bar">
    <button id="backButton" class="icon-button">
      <img src="{{ asset('images/icons/back.png') }}" alt="Назад">
    </button>
    <h1 class="page-title">ИСТОРИЯ</h1>
  </div>

  <!-- Горизонтальный разделитель -->
  <hr class="separator">

  <!-- Контейнер для списка тренировок с прокруткой -->
  <div class="workout-container">
    <div id="workoutList"></div>
  </div>

  <!-- Нижняя панель навигации -->
  <nav class="bottom-nav">
    <a href="{{ url('/shop') }}" class="nav-link">
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

  <!-- Подключение JavaScript через Laravel Mix -->
  <script src="{{ asset('js/workouts.js') }}"></script>
</body>
</html>
