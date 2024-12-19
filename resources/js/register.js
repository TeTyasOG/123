// register.js

document.addEventListener('DOMContentLoaded', () => {
    const registerForm = document.getElementById('registerForm');
  
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
  
      try {
        const response = await fetch('/register', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ nickname, email, password, gender, weight })
        });
  
        if (response.ok) {
          alert('Регистрация успешна!');
          window.location.href = '/profile.html';
        } else {
          const errorData = await response.json();
          alert('Ошибка: ' + errorData.message);
        }
      } catch (error) {
        console.error('Ошибка:', error);
        alert('Произошла ошибка при регистрации.');
      }
    });
  });
  