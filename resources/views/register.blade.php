<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Регистрация</title>
  @vite(['resources/css/register.css', 'resources/js/register.js'])
  <!-- Подключение стилей через Laravel Mix -->
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

  <!-- Подключение шрифта INTRO -->
  <style>
    @font-face {
      font-family: 'INTRO';
      src: url('{{ asset('fonts/INTRO.ttf') }}') format('truetype');
    }
  </style>
</head>
<body>
  <!-- Верхняя панель -->
  <div class="top-bar">
    <h1 class="page-title">РЕГИСТРАЦИЯ</h1>
  </div>
  <hr class="separator">

  <div class="form-container">
    <!-- Форма регистрации -->
    <form id="registerForm" method="POST" action="{{ route('register') }}">
      @csrf <!-- Защита от CSRF -->
      
      <div class="form-item">
        <div class="form-label">Никнейм:</div>
        <input type="text" id="nickname" name="nickname" class="form-input" required placeholder="Введите никнейм">
      </div>

      <div class="form-item">
        <div class="form-label">Email:</div>
        <input type="email" id="email" name="email" class="form-input" required placeholder="Введите Email">
      </div>

      <div class="form-item">
        <div class="form-label">Пароль:</div>
        <input type="password" id="password" name="password" class="form-input" required placeholder="Введите пароль">
      </div>

      <div class="form-item">
        <div class="form-label">Пол:</div>
        <select id="gender" name="gender" class="form-select" required>
          <option value="">Выберите пол</option>
          <option value="male">Мужской</option>
          <option value="female">Женский</option>
        </select>
      </div>

      <div class="form-item">
        <div class="form-label">Вес (кг):</div>
        <input type="number" id="weight" name="weight" class="form-input" required placeholder="Введите вес">
      </div>

      <button type="submit" class="form-button">Зарегистрироваться</button>
    </form>

    <div class="auth-link">
      Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
    </div>
  </div>

  <!-- Подключение JavaScript через Laravel Mix -->
  <script src="{{ asset('js/register.js') }}"></script>
</body>
</html>
