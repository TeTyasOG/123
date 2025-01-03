document.addEventListener('DOMContentLoaded', () => {
    const modalOverlay = document.getElementById('modalOverlay');
    const modalText = document.getElementById('modalText');
    const modalOkButton = document.getElementById('modalOkButton');
  
    function showModal(text) {
      modalText.textContent = text;
      modalOverlay.style.display = 'block';
  
      // Закрытие по кнопке "ОК"
      modalOkButton.addEventListener('click', closeModal);
  
      // Закрытие при клике на фон
      modalOverlay.addEventListener('click', function overlayHandler(e) {
        if (e.target === modalOverlay) {
          closeModal();
          modalOverlay.removeEventListener('click', overlayHandler); // Убираем обработчик после закрытия
        }
      });
    }
  
    function closeModal() {
      modalOverlay.style.display = 'none';
    }

    loginForm.addEventListener('submit', async (event) => {
        event.preventDefault();
    
        const login = document.getElementById('login').value;
        const password = document.getElementById('password').value;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
        try {
            const response = await fetch(loginForm.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
                body: JSON.stringify({ login, password }),
            });
    
            if (response.ok) {
                // Если сервер вернул успешный статус
                const contentType = response.headers.get('Content-Type') || '';
                if (contentType.includes('application/json')) {
                    const data = await response.json();
                    window.location.href = '/profile'; // Перенаправление на профиль
                } else {
                    // Если сервер вернул не JSON
                    window.location.href = '/profile'; // Возможный редирект, если всё успешно
                }
            } else {
                // Если статус не OK, пытаемся обработать ошибку
                const contentType = response.headers.get('Content-Type') || '';
                if (contentType.includes('application/json')) {
                    const errorData = await response.json();
                    showModal('Ошибка: ' + (errorData.message || 'Неизвестная ошибка'));
                } else {
                    // Если сервер вернул HTML (например, 419 ошибка)
                    showModal('Ошибка авторизации. Код ответа: ' + response.status);
                }
            }
        } catch (error) {
            console.error('Ошибка при входе:', error);
            showModal('Произошла ошибка при входе. Пожалуйста, повторите попытку.');
        }
    });
    
  });
  


  