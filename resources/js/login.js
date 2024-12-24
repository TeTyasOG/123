document.addEventListener('DOMContentLoaded', () => {
  const loginForm = document.getElementById('loginForm');

  loginForm.addEventListener('submit', async (event) => {
      event.preventDefault();

      // Собираем данные формы:
      const login = document.getElementById('login').value;
      const password = document.getElementById('password').value;

      // CSRF-токен из метатега
      const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

      try {
          // Делаем запрос на тот же action, что указан в форме
          const response = await fetch(loginForm.action, {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'Accept': 'application/json',
                  'X-CSRF-TOKEN': csrfToken,
                  'X-Requested-With': 'XMLHttpRequest',
              },
              // Обязательно, чтобы Laravel получал куку сессии
              credentials: 'same-origin',
              body: JSON.stringify({ login, password }),
          });

          // Если Laravel вернул 419, он обычно возвращает HTML-страницу,
          // поэтому тут придётся либо проверять response.headers,
          // либо пытаться прочитать JSON, и если не сработает, выводить, что произошла 419 ошибка.
          if (response.ok) {
              // Тут вернётся JSON
              const data = await response.json();
              // Перенаправляем на /profile
              window.location.href = '/profile';
          } else {
              // Если статус не ok, пытаемся вывести сообщение из JSON
              // Например, 400 (Bad Request) от «Неверный логин или пароль»
              // или 500 (Internal Server Error) и т.д.
              let /profilerrorData;
              try {
                  errorData = await response.json();
                  alert('Ошибка: ' + (errorData.message || 'Неизвестная ошибка'));
              } catch (e) {
                  // Если не получилось распарсить JSON, значит пришёл HTML (возможно 419)
                  alert('Ошибка авторизации (возможно CSRF токен устарел). Код ответа: ' + response.status);
              }
          }
      } catch (error) {
          console.error('Ошибка при входе:', error);
          alert('Произошла ошибка при входе.');
      }
  });
});
