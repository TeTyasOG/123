<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Регистрация</title>
  <!-- Подключение стилей -->
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <!-- Форма регистрации -->
  <form id="registerForm">
    <label for="nickname">Никнейм:</label>
    <input type="text" id="nickname" name="nickname" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Пароль:</label>
    <input type="password" id="password" name="password" required>

    <label for="gender">Пол:</label>
    <select id="gender" name="gender" required>
      <option value="" disabled selected>Выберите пол</option>
      <option value="male">Мужской</option>
      <option value="female">Женский</option>
    </select>

    <label for="weight">Вес (кг):</label>
    <input type="number" id="weight" name="weight" step="0.1" required>

    <button type="submit">Зарегистрироваться</button>
  </form>

  <!-- Встроенный JS -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const registerForm = document.getElementById('registerForm');

      if (!registerForm) {
          console.error('Register form not found!');
          return;
      }

      registerForm.addEventListener('submit', async (event) => {
          event.preventDefault();

          const nickname = document.getElementById('nickname').value;
          const email = document.getElementById('email').value;
          const password = document.getElementById('password').value;
          const gender = document.getElementById('gender').value;
          const weight = parseFloat(document.getElementById('weight').value);

          // Проверка заполнения полей
          if (!gender) {
              alert('Пожалуйста, выберите пол.');
              return;
          }
          if (weight <= 0) {
              alert('Пожалуйста, введите корректный вес.');
              return;
          }

          const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

          try {
              const response = await fetch('/register', {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json',
                      'X-CSRF-TOKEN': csrfToken,
                  },
                  body: JSON.stringify({ nickname, email, password, gender, weight })
              });

              if (response.ok) {
                  alert('Регистрация успешна!');
                  window.location.href = '/profile';
              } else {
                const errorText = await response.text();
                console.error('Ошибка:', errorText);
                alert('Ошибка: ' + errorText);
                
              }
          } catch (error) {
              console.error('Ошибка:', error);
              alert('Произошла ошибка при регистрации.');
          }
      });
    });
  </script>
</body>
</html>
