<!-- resources/views/exercise.blade.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Упражнение</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite(['resources/css/exercise.css', 'resources/js/exercise.js'])
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/exercise.css') }}">
  <style>
    @font-face {
      font-family: 'INTRO';
      src: url('{{ asset('fonts/INTRO.ttf') }}') format('truetype');
      font-weight: normal;
      font-style: normal;
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
  </div>
  <hr class="separator">

  <div id="exerciseContainer">
    <!-- Видео упражнения -->
    <video id="exerciseVideo" class="exercise-video"></video>
    <hr class="separator">

    <!-- Название упражнения -->
    <div class="exercise-name-line">
      <span id="exerciseName" class="exercise-name"></span>
    </div>

    <!-- Основная и дополнительная мышца -->
    <div class="muscle-info">
      <div id="mainMuscle" class="muscle-text"></div>
      <div id="additionalMuscles" class="muscle-text"></div>
    </div>
    <hr class="thin-separator">

    <!-- Звание -->
    <div class="rank-title">ЗВАНИЕ</div>
    <div id="rankBox" class="rank-box"></div>
    <hr class="thin-separator">

    <!-- Лучшие показатели -->
    <div class="best-stats-titles">
      <div class="best-stat-title">ЛУЧШИЙ ВЕС</div>
      <div class="best-stat-title">ЛУЧШИЙ<br>УРОВЕНЬ</div>
      <div class="best-stat-title">ЛУЧШИЙ<br>ОПЫТ</div>
    </div>
    <div class="best-stats-values">
      <div class="best-stat-box">
        <span id="bestWeightVal" class="best-value">0</span><br>
        <span id="bestWeightUnit" class="best-unit">КГ</span>
      </div>
      <div class="best-stat-box">
        <span id="bestLevelVal" class="best-value">0</span><br>
        <span id="bestLevelUnit" class="best-unit">ЛВЛ</span>
      </div>
      <div class="best-stat-box">
        <span id="bestXPVal" class="best-value">0</span><br>
        <span id="bestXPUnit" class="best-unit">ОП</span>
      </div>
    </div>
    <hr class="thin-separator">

    <!-- Описание -->
    <div class="section-title-left">ОПИСАНИЕ</div>
    <div class="description-text" id="descriptionText">Нет описания.</div>
    <hr class="thin-separator">

    <!-- Советы -->
    <div class="section-title-left">СОВЕТЫ</div>
    <ul class="tips-list" id="tipsList">
      <li>Нет советов.</li>
    </ul>
  </div>

  <!-- Убираем нижнюю панель навигации, удаляем ее полностью -->
  
  <script src="{{ asset('js/exercise.js') }}"></script>
</body>
</html>
