// edit_profile.js

document.addEventListener('DOMContentLoaded', () => {
    const editProfileForm = document.getElementById('editProfileForm');
    const cancelButton = document.getElementById('cancelButton');
  
    // Загрузка текущих данных пользователя
    async function loadUserData() {
      try {
        const response = await fetch('/getUserProfile');
        if (response.ok) {
          const user = await response.json();
          document.getElementById('weight').value = user.weight || '';
        } else {
          console.error('Ошибка при загрузке данных пользователя.');
        }
      } catch (error) {
        console.error('Ошибка:', error);
      }
    }
  
    loadUserData();
  
    // Обработчик отправки формы
    editProfileForm.addEventListener('submit', async (event) => {
      event.preventDefault();
  
      const weight = parseFloat(document.getElementById('weight').value);
  
      if (weight <= 0) {
        alert('Пожалуйста, введите корректный вес.');
        return;
      }
  
      try {
        const response = await fetch('/updateProfile', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ weight })
        });
  
        if (response.ok) {
          alert('Профиль успешно обновлён.');
          window.location.href = '/profile';
        } else {
          const errorData = await response.json();
          alert('Ошибка: ' + errorData.message);
        }
      } catch (error) {
        console.error('Ошибка:', error);
        alert('Произошла ошибка при обновлении профиля.');
      }
    });
  
    // Обработчик кнопки "Отмена"
    cancelButton.addEventListener('click', () => {
      window.location.href = '/profile';
    });
  });
  