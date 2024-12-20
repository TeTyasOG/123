document.addEventListener('DOMContentLoaded', () => {
  const loginForm = document.getElementById('loginForm');

  loginForm.addEventListener('submit', async (event) => {
    event.preventDefault();

    const login = document.getElementById('login').value;
    const password = document.getElementById('password').value;

    // Получаем CSRF-токен из мета-тега
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    try {
      const response = await fetch('/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken, // Добавляем токен сюда
        },
        body: JSON.stringify({ login, password }),
      });

      if (response.ok) {
        alert('Вход выполнен успешно!');
        window.location.href = '/profile.html';
      } else {
        const errorData = await response.json();
        alert('Ошибка: ' + errorData.message);
      }
    } catch (error) {
      console.error('Ошибка:', error);
      alert('Произошла ошибка при входе.');
    }
  });
});
