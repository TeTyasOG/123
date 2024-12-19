document.addEventListener('DOMContentLoaded', async () => {
  const backButton = document.getElementById('backButton');
  const saveButton = document.getElementById('saveButton');
  const nicknameInput = document.getElementById('nickname');
  const genderSelect = document.getElementById('gender');
  const weightInput = document.getElementById('weight');

  let userData = {};
  let originalNickname = '';
  let originalGender = '';
  let originalWeight = 0;

  // Модальное окно
  const modalOverlay = document.getElementById('modalOverlay');
  const modalText = document.getElementById('modalText');
  const modalButtons = document.getElementById('modalButtons');

  function showModal(text, buttons, onCloseOverlay = true) {
    modalText.textContent = text;
    modalButtons.innerHTML = '';
    buttons.forEach(btn => {
      const buttonEl = document.createElement('button');
      buttonEl.classList.add('modal-button');
      if (btn.blue) buttonEl.classList.add('modal-button-blue');
      buttonEl.textContent = btn.text;
      buttonEl.addEventListener('click', () => {
        if (btn.onClick) btn.onClick();
      });
      modalButtons.appendChild(buttonEl);
    });

    modalOverlay.style.display = 'block';

    if (onCloseOverlay) {
      modalOverlay.addEventListener('click', overlayHandler);
    } else {
      modalOverlay.removeEventListener('click', overlayHandler);
    }
  }

  function overlayHandler(e) {
    if (e.target === modalOverlay) {
      closeModal();
    }
  }

  function closeModal() {
    modalOverlay.style.display = 'none';
    modalButtons.innerHTML = '';
  }

  async function loadUserData() {
    try {
      const response = await fetch('/getUserProfile');
      if (!response.ok) {
        throw new Error('Ошибка при загрузке профиля пользователя');
      }
      userData = await response.json();
      originalNickname = userData.nickname || '';
      originalGender = userData.gender || '';
      originalWeight = userData.weight || 0;

      nicknameInput.value = '';
      nicknameInput.placeholder = originalNickname;
      genderSelect.value = originalGender || '';
      weightInput.value = '';
      weightInput.placeholder = originalWeight.toString();
    } catch (error) {
      console.error('Ошибка при загрузке данных пользователя:', error);
      // Показываем модалку об ошибке
      showModal('Ошибка при загрузке данных пользователя', [
        { text: 'ОК', onClick: () => { closeModal(); window.location.href = '/profile.html'; } }
      ], false);
    }
  }

  backButton.addEventListener('click', () => {
    window.location.href = '/profile.html';
  });

  // Проверка полей
  function validateInputs(newNickname, newGender, newWeight) {
    // ВОЗМОЖНЫЕ ОШИБКИ ВВОДА (можете убрать при необходимости):
    // - nickname слишком короткий (<3 символов)
    // - gender не выбран
    // - weight <=0 или не число

    if (newNickname.length < 3) return 'Никнейм слишком короткий. Должно быть не менее 3 символов.';
    if (!newGender) return 'Пол не выбран. Пожалуйста, выберите пол.';
    if (newWeight <= 0 || isNaN(newWeight)) return 'Некорректный вес. Введите число больше 0.';

    return null; // Нет ошибок
  }

  saveButton.addEventListener('click', async () => {
    const newNickname = nicknameInput.value.trim() || originalNickname;
    const newGender = genderSelect.value || originalGender;
    const newWeight = weightInput.value.trim() ? parseFloat(weightInput.value) : originalWeight;

    const error = validateInputs(newNickname, newGender, newWeight);
    if (error) {
      // Показываем модалку с ошибкой валидации
      showModal(error, [
        { text: 'ОК', onClick: () => { closeModal(); } }
      ], true);
      return;
    }

    // Показываем модалку подтверждения
    showModal('Вы хотите изменить настройки профиля?', [
      { text: 'ОТМЕНА', onClick: () => { closeModal(); } },
      { text: 'ДА', blue: true, onClick: async () => {
        closeModal();
        // Пробуем сохранить
        try {
          const response = await fetch('/updateProfile', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nickname: newNickname, gender: newGender, weight: newWeight })
          });

          if (response.ok) {
            // Успешно, переходим на profile.html без уведомления
            window.location.href = '/profile.html';
          } else {
            const errorData = await response.json();
            // Ошибка сохранения
            showModal('ПРОИЗОШЛА ОШИБКА В СОХРАНЕНИИ НАСТРОЕК', [
              { text: 'ОК', onClick: () => { closeModal(); } }
            ], true);
            console.error('Ошибка сохранения:', errorData.message);
          }
        } catch (error) {
          console.error('Ошибка:', error);
          // Ошибка сохранения
          showModal('ПРОИЗОШЛА ОШИБКА В СОХРАНЕНИИ НАСТРОЕК', [
            { text: 'ОК', onClick: () => { closeModal(); } }
          ], true);
        }
      }}
    ], true);
  });

  nicknameInput.addEventListener('input', () => {
    if (nicknameInput.value.length > 0) {
      nicknameInput.placeholder = '';
    } else {
      nicknameInput.placeholder = originalNickname;
    }
  });

  weightInput.addEventListener('input', () => {
    if (weightInput.value.length > 0) {
      weightInput.placeholder = '';
    } else {
      weightInput.placeholder = originalWeight.toString();
    }
  });

  await loadUserData();
});
