<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Тренировка (История)</title>
    @vite(['resources/css/workout_detail.css', 'resources/js/workout_detail.js'])
    <!-- Подключение стилей через Laravel Mix -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/workout_detail.css') }}">
    <!-- Подключение шрифта INTRO -->
    <style>
      @font-face {
        font-family: 'INTRO';
        src: url('{{ asset('fonts/INTRO.ttf') }}') format('truetype');
      }

      body {
        font-family: 'INTRO', sans-serif;
        overflow: auto; /* Прокрутка страницы */
      }
    </style>
</head>
<body>
  <div id="modalOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999;">
    <div id="modalContent" style="position:relative; margin:auto; top:20%; max-width:400px; padding:20px; background:white; border-radius:8px; text-align:center;">
      <p id="modalText"></p>
      <button id="modalOkButton" style="margin-top:20px; padding:10px 20px;">ОК</button>
    </div>
  </div>
  
    <!-- Верхняя панель -->
    <div class="top-bar">
      <button id="backButton" class="icon-button">
        <img src="{{ asset('images/icons/back.png') }}" alt="Назад">
      </button>
      <h1 id="pageTitle">ИСТОРИЯ ТРЕНИРОВКИ</h1>
    </div>
    <hr class="separator">

    <!-- Статистика тренировки -->
    <div class="workout-stats">
      <div class="stat-item">
        <span class="stat-label">ВРЕМЯ</span>
        <span id="timeValue" class="stat-value">0С</span>
      </div>
      <div class="stat-item">
        <span class="stat-label">ОПЫТ</span>
        <span id="xpValue" class="stat-value">0 XP</span>
      </div>
      <div class="stat-item">
        <span class="stat-label">СЕТОВ</span>
        <span id="setsValue" class="stat-value">0</span>
      </div>
    </div>
    <hr class="separator">

    <!-- Список упражнений -->
    <div id="exercises">
      <!-- Упражнения будут добавлены динамически -->
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
    <script src="{{ asset('js/workout_detail.js') }}"></script>
</body>
</html>
