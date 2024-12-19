<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Настройки профиля</title>
  <link rel="stylesheet" href="{{ asset('css/profile_settings.css') }}">
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
    <h1 class="page-title">НАСТРОЙКИ ПРОФИЛЯ</h1>
    <button id="saveButton" class="icon-button">
      <img src="{{ asset('images/icons/check.png') }}" alt="Сохранить">
    </button>
  </div>

  <!-- Настройки профиля -->
  <div class="settings-container">
    <div class="setting-item">
      <div class="setting-label">НИКНЕЙМ:</div>
      <input type="text" id="nickname" class="setting-input" placeholder="">
    </div>

    <div class="setting-item">
      <div class="setting-label">ПОЛ:</div>
      <select id="gender" class="setting-select">
        <option value="" disabled selected>Выберите пол</option>
        <option value="male">Мужской</option>
        <option value="female">Женский</option>
      </select>
    </div>

    <div class="setting-item">
      <div class="setting-label">ВЕС (КГ):</div>
      <input type="number" id="weight" class="setting-input" placeholder="">
    </div>
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

  <!-- Модальное окно -->
  <div id="modalOverlay" class="modal-overlay">
    <div class="modal-window">
      <div class="modal-text" id="modalText"></div>
      <div class="modal-buttons" id="modalButtons"></div>
    </div>
  </div>

  <script src="{{ asset('js/profile_settings.js') }}"></script>
</body>
</html>
