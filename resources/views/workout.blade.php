<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Тренировка</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite(['resources/css/workout.css', 'resources/js/workout.js'])
  <!-- Подключение стилей через Laravel Mix -->
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/workout.css') }}">
  <!-- Подключение шрифта INTRO -->
  <style>
    @font-face {
      font-family: 'INTRO';
      src: url('{{ asset('fonts/INTRO.ttf') }}') format('truetype');
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
    <h1 id="pageTitle">ТРЕНИРОВКА</h1>
    <button id="finishButton" class="icon-button">
      <img src="{{ asset('images/icons/check.png') }}" alt="Завершить">
    </button>
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
      <span class="stat-label">СЕТЫ</span>
      <span id="setsValue" class="stat-value">0</span>
    </div>
  </div>
  <hr class="separator">

  <!-- Список упражнений -->
  <div id="exercises">
    <!-- Упражнения будут добавлены динамически -->
  </div>

  <!-- Кнопки добавления упражнения и удаления тренировки -->
  <div class="action-buttons">
    <button id="addExerciseButton" class="primary-button">+ ДОБАВИТЬ УПРАЖНЕНИЕ</button>
    <button id="deleteWorkoutButton" class="secondary-button">УДАЛИТЬ</button>
  </div>

  <!-- Модальное окно для выбора упражнений -->
  <div id="exerciseModal" class="modal">
    <div class="modal-content">
      <span id="closeExerciseModal" class="close">&times;</span>
      <h2>Выберите упражнение</h2>
      <!-- Список упражнений для выбора -->
      <div id="exerciseList">
        <!-- Карточки упражнений будут добавлены динамически -->
      </div>
    </div>
  </div>

  <!-- Модальное окно настроек упражнения -->
  <div id="exerciseSettingsModal" class="modal">
    <div class="modal-content">
      <!-- Окно настроек будет заполнено динамически -->
    </div>
  </div>

  <!-- Подключение скриптов через Laravel Mix -->
  <script src="{{ asset('js/workout.js') }}"></script>
</body>
</html>
