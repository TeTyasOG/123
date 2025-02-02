<!DOCTYPE html>
<html lang="ru">
<head>
  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Профиль</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite(['resources/css/profile.css', 'resources/js/profile.js'])
  <!-- Подключение стилей -->
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
  <style>
    @font-face {
      font-family: 'INTRO';
      src: url('{{ asset('fonts/INTRO.ttf') }}') format('truetype');
    }
    
  </style>
</head>
<div id="modalOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999;">
  <div id="modalContent" style="position:relative; margin:auto; top:20%; max-width:400px; padding:20px; background:white; border-radius:8px; text-align:center;">
    <p id="modalText"></p>
    <button id="modalOkButton" style="margin-top:20px; padding:10px 20px;">ОК</button>
  </div>
</div>

<body>
  <!-- Верхняя панель с кнопками -->
  <div class="top-bar">
    <button id="logoutButton" class="icon-button">
      <img src="{{ asset('images/icons/door.png') }}" alt="Выйти">
    </button>
    <h1 id="userNickname">{{ Auth::user()->nickname ?? 'Никнейм' }}</h1>
    <button id="settingsButton" class="icon-button">
      <img src="{{ asset('images/icons/gear.png') }}" alt="Настройки">
    </button>
  </div>

  <div class="screens-wrapper">
    <!-- Стрелки -->
    <button class="icon-button arrow-left">
      <img src="{{ asset('images/icons/back.png') }}" alt="Назад">
    </button>
    <button class="icon-button arrow-right">
      <img src="{{ asset('images/icons/next.png') }}" alt="Вперед">
    </button>
  
    <div class="screens-container">
      <div class="screen left-screen">
        <!-- Здесь будут крупные мышцы (3 шт) через JS -->
      </div>
      <div class="screen center-screen">
        <div class="center-content">
          <div class="main-level-container">
            <div class="progress-container">
              <div class="progress-circle">
                <span id="userLevel">1</span>
                <canvas id="progressCanvas" width="200" height="200"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="screen right-screen">
        <!-- Здесь будут мелкие мышцы (3 шт) через JS -->
      </div>
    </div>
  </div>
  
  <div class="buttons">
    <!-- Кнопка "История тренировок" -->
    <button id="workoutHistoryButton" class="text-button">ИСТОРИЯ ТРЕНИРОВОК</button>

    <!-- Контейнер для отображения процента заполненности уровня -->
    <div id="levelProgressContainer" class="level-progress-container">
      <p id="levelProgressText">99%</p>
    </div>

    <!-- Кнопка "Замеры" -->
    <button id="measurementsButton" class="text-button">ЗАМЕРЫ</button>
  </div>

  <div class="achievements-container">
    <h2 class="section-title">ДОСТИЖЕНИЯ</h2>
    <p class="empty-text">ПОКА ТУТ ПУСТО</p>
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
    <a href="{{ url('/profile') }}" class="nav-link active">
      <img src="{{ asset('images/icons/profile.png') }}" alt="Профиль">
      <span>ПРОФИЛЬ</span>
    </a>
  </nav>

  <!-- Подключение скриптов -->
  <script src="{{ asset('js/profile.js') }}"></script>
</body>
</html>
