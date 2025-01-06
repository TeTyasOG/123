<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Регистрация</h1>

    <!-- Вывод ошибок -->
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Вывод сообщения об успехе -->
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Форма регистрации -->
    <form method="POST" action="{{ route('register') }}">
        @csrf <!-- CSRF токен обязателен -->

        <!-- Поле "Никнейм" -->
        <label for="nickname">Никнейм:</label>
        <input type="text" id="nickname" name="nickname" value="{{ old('nickname') }}" required>
        @error('nickname')
            <div style="color: red;">{{ $message }}</div>
        @enderror
        <br>

        <!-- Поле "Email" -->
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        @error('email')
            <div style="color: red;">{{ $message }}</div>
        @enderror
        <br>

        <!-- Поле "Пароль" -->
        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required>
        @error('password')
            <div style="color: red;">{{ $message }}</div>
        @enderror
        <br>

        <!-- Поле "Подтверждение пароля" -->
        <label for="password_confirmation">Подтверждение пароля:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
        <br>

        <!-- Поле "Пол" -->
        <label for="gender">Пол:</label>
        <select id="gender" name="gender" required>
            <option value="" disabled selected>Выберите пол</option>
            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Мужской</option>
            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Женский</option>
        </select>
        @error('gender')
            <div style="color: red;">{{ $message }}</div>
        @enderror
        <br>

        <!-- Поле "Вес" -->
        <label for="weight">Вес (кг):</label>
        <input type="number" id="weight" name="weight" value="{{ old('weight') }}" min="1" required>
        @error('weight')
            <div style="color: red;">{{ $message }}</div>
        @enderror
        <br>

        <!-- Кнопка отправки -->
        <button type="submit">Зарегистрироваться</button>
    </form>
</body>
</html>
