<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Замеры</title>
  <link rel="stylesheet" href="{{ asset('css/measurements.css') }}">
  <style>
    @font-face {
      font-family: 'INTRO';
      src: url('{{ asset('fonts/INTRO.ttf') }}') format('truetype');
    }
    body {
      font-family: 'INTRO', sans-serif;
      margin: 0;
      padding: 0;
      background: #f3f2f8;
    }
  </style>
</head>
<body>
  <!-- Верхняя панель -->
  <div class="top-bar">
    <button id="backButton" class="icon-button">
      <img src="{{ asset('images/icons/back.png') }}" alt="Назад">
    </button>
    <h1 class="page-title">ЗАМЕРЫ</h1>
    <button id="addButton" class="icon-button">
      <img src="{{ asset('images/icons/add.png') }}" alt="Добавить">
    </button>
  </div>

  <!-- История замеров -->
  <div id="measurementsHistory" class="measurements-history">
    <!-- Динамически добавляем контейнеры замеров и тонкие разделители -->
  </div>

  <!-- Нижняя навигационная панель -->
  <nav class="bottom-nav">
    <a href="{{ route('shop') }}" class="nav-link">
      <img src="{{ asset('images/icons/shop.png') }}" alt="Магазин">
      <span>МАГАЗИН</span>
    </a>
    <a href="{{ route('training') }}" class="nav-link">
      <img src="{{ asset('images/icons/training.png') }}" alt="Тренировка">
      <span>ТРЕНИРОВКА</span>
    </a>
    <a href="{{ route('profile') }}" class="nav-link">
      <img src="{{ asset('images/icons/profile.png') }}" alt="Профиль">
      <span>ПРОФИЛЬ</span>
    </a>
  </nav>

  <!-- Модальное окно для добавления замеров -->
  <div id="addMeasurementsModal" class="modal">
    <div class="modal-content">
      <h2 class="modal-title">ДОБАВИТЬ ЗАМЕРЫ</h2>
      <div class="modal-form-grid" id="measurementsForm">
        <!-- Поля замеров будут добавлены динамически -->
      </div>
      <div class="modal-buttons">
        <button id="cancelModalButton" class="modal-button">ОТМЕНА</button>
        <button id="applyChangesButton" class="modal-button modal-button-blue">ПРИМЕНИТЬ ИЗМЕНЕНИЯ</button>
      </div>
    </div>
  </div>

  <script src="{{ asset('js/measurements.js') }}"></script>
</body>
</html>
