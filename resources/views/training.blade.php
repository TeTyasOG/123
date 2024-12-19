<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Тренировка</title>
  <!-- Подключение стилей через Laravel Mix -->
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/training.css') }}">
  <style>
    @font-face {
      font-family: 'INTRO';
      src: url('{{ asset('fonts/INTRO.ttf') }}') format('truetype');
    }
  </style>
</head>
<body>
  <!-- Верхняя надпись -->
  <div class="top-header">
    <h1 id="pageTitle">ТРЕНИРОВКА</h1>
    <hr class="separator">
  </div>

  <!-- Кнопки "НАЧАТЬ ТРЕНИРОВКУ" и "СОЗДАТЬ ПРОГРАММУ" -->
  <div class="main-buttons">
    <button id="startWorkoutButton" class="primary-button">НАЧАТЬ ТРЕНИРОВКУ</button>
    <button id="createProgramButton" class="primary-button">СОЗДАТЬ ПРОГРАММУ</button>
  </div>
  <hr class="separator">

  <!-- Заголовок "ВЫБРАТЬ ПРОГРАММУ" -->
  <h2 class="section-title">ВЫБРАТЬ ПРОГРАММУ</h2>

  <!-- Список программ -->
  <div id="programList" class="program-list">
    <!-- Программы будут динамически добавлены через JavaScript -->
  </div>

  <!-- Модальное окно запуска программы -->
  <div id="startProgramModal" class="modal">
    <div class="modal-content">
      <p id="startProgramMessage"></p>
      <div class="modal-buttons">
        <button id="confirmStartProgram" class="confirm-button">Да</button>
        <button id="cancelStartProgram" class="cancel-button">Отмена</button>
      </div>
    </div>
  </div>

  <!-- Нижняя навигационная панель -->
  <nav class="bottom-nav">
    <a href="{{ url('/shop') }}" class="nav-link">
      <img src="{{ asset('images/icons/shop.png') }}" alt="Магазин">
      <span>МАГАЗИН</span>
    </a>
    <a href="{{ url('/training') }}" class="nav-link active">
      <img src="{{ asset('images/icons/training.png') }}" alt="Тренировка">
      <span>ТРЕНИРОВКА</span>
    </a>
    <a href="{{ url('/profile') }}" class="nav-link">
      <img src="{{ asset('images/icons/profile.png') }}" alt="Профиль">
      <span>ПРОФИЛЬ</span>
    </a>
  </nav>

  <!-- Подключение JavaScript через Laravel Mix -->
  <script src="{{ asset('js/training.js') }}"></script>
</body>
</html>
