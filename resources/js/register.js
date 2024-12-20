// Updated register.js

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
