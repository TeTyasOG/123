<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <!-- Генерация CSRF-токена для JS -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Vite или ваши сборщики -->
    @vite(['resources/css/auth.css', 'resources/js/login.js'])

    <!-- Если нужно, подключаем стили напрямую -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

    <!-- Подключение шрифта INTRO -->
    <style>
        @font-face {
            font-family: 'INTRO';
            src: url('{{ asset('fonts/INTRO.ttf') }}') format('truetype');
        }
    </style>
    <div id="modalOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999;">
  <div id="modalContent" style="position:relative; margin:auto; top:20%; max-width:400px; padding:20px; background:white; border-radius:8px; text-align:center;">
    <p id="modalText"></p>
    <button id="modalOkButton" style="margin-top:20px; padding:10px 20px;">ОК</button>
  </div>
</div>

</head>
<body>
    <!-- Верхняя панель -->
    <div class="top-bar">
        <h1 class="page-title">ВХОД</h1>
    </div>
    <hr class="separator">

    <div class="form-container">
        {{-- Обратите внимание: если route('login') у вас POST, то всё хорошо --}}
        <form id="loginForm" method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="form-item">
                <div class="form-label">Email или никнейм:</div>
                <input type="text" id="login" name="login" class="form-input" required placeholder="Введите Email или никнейм">
            </div>

            <div class="form-item">
                <div class="form-label">Пароль:</div>
                <input type="password" id="password" name="password" class="form-input" required placeholder="Введите пароль">
            </div>

            <button type="submit" class="form-button">Войти</button>
        </form>

        <div class="auth-link">
            Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a>
        </div>
    </div>

    <!-- Подключаем JS (если у вас Vite, то выше указывали @vite(['resources/js/login.js']), можно убрать отсюда) -->
    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
