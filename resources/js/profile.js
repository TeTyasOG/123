document.addEventListener('DOMContentLoaded', () => {
  const userNickname     = document.getElementById('userNickname');
  const userLevel        = document.getElementById('userLevel');
  const progressCanvas   = document.getElementById('progressCanvas');
  const logoutButton     = document.getElementById('logoutButton');
  const settingsButton   = document.getElementById('settingsButton');
  const workoutHistoryButton = document.getElementById('workoutHistoryButton');
  const measurementsButton   = document.getElementById('measurementsButton');
  const levelProgressText    = document.getElementById('levelProgressText');

  // Было: bigMusclesList = [... 6 элементов ...], smallMusclesList = [... 6 элементов ...]
  // Стало: теперь 3 крупных, 3 мелких. Итого 6, как в миграции ['Грудь', 'Спина', 'Пресс', 'Ноги', 'Плечи', 'Руки']
  // Допустим «крупные» = ['Грудь', 'Спина', 'Ноги']
  //         «мелкие»  = ['Плечи', 'Пресс', 'Руки']
  const bigMusclesList   = ['Грудь', 'Спина', 'Ноги'];
  const smallMusclesList = ['Плечи', 'Пресс', 'Руки'];

  // Карта иконок (новая, на 6 мышц)
  const muscleIconsMap = {
    'Грудь':  'chest.png',
    'Спина':  'back.png',
    'Ноги':   'legs.png',
    'Плечи':  'shoulders.png',
    'Пресс':  'abs.png',
    'Руки':   'arms.png'
  };

  let userData = {}; // тут будет всё, что пришло с сервера
  
  // Логика переключения экранов
  let currentScreen = 'center';
  const screensContainer = document.querySelector('.screens-container');
  const arrowLeft = document.querySelector('.arrow-left');
  const arrowRight = document.querySelector('.arrow-right');

  function goToLeftScreen() {
    screensContainer.style.transform = 'translateX(0)';
    currentScreen = 'left';
    updateArrowsVisibility();
  }
  function goToCenterScreen() {
    screensContainer.style.transform = 'translateX(-100vw)';
    currentScreen = 'center';
    updateArrowsVisibility();
  }
  function goToRightScreen() {
    screensContainer.style.transform = 'translateX(-200vw)';
    currentScreen = 'right';
    updateArrowsVisibility();
  }
  function updateArrowsVisibility() {
    if (currentScreen === 'center') {
      arrowLeft.style.display = 'block';
      arrowRight.style.display = 'block';
    } else if (currentScreen === 'left') {
      arrowLeft.style.display = 'none';
      arrowRight.style.display = 'block';
    } else if (currentScreen === 'right') {
      arrowLeft.style.display = 'block';
      arrowRight.style.display = 'none';
    }
  }
  arrowLeft.addEventListener('click', () => {
    if (currentScreen === 'center') {
      goToLeftScreen();
    } else if (currentScreen === 'right') {
      goToCenterScreen();
    }
  });
  arrowRight.addEventListener('click', () => {
    if (currentScreen === 'center') {
      goToRightScreen();
    } else if (currentScreen === 'left') {
      goToCenterScreen();
    }
  });

  // Свайпы
  let startX = 0;
  let isSwiping = false;
  screensContainer.addEventListener('touchstart', (e) => {
    startX = e.touches[0].clientX;
    isSwiping = true;
  });
  screensContainer.addEventListener('touchmove', (e) => {
    if (!isSwiping) return;
  });
  screensContainer.addEventListener('touchend', (e) => {
    if (!isSwiping) return;
    isSwiping = false;
    const endX = e.changedTouches[0].clientX;
    const deltaX = endX - startX;
    if (deltaX > 50) {
      // свайп вправо
      if (currentScreen === 'center') goToLeftScreen();
      else if (currentScreen === 'right') goToCenterScreen();
    } else if (deltaX < -50) {
      // свайп влево
      if (currentScreen === 'center') goToRightScreen();
      else if (currentScreen === 'left') goToCenterScreen();
    }
  });

  // Функция подстановки CSS-переменных
  function getCSSVariable(name) {
    return getComputedStyle(document.documentElement).getPropertyValue(name).trim();
  }

  // Функция отрисовки круга прогресса уровня
  function drawProgressCircle() {
    const progressSize     = parseInt(getCSSVariable('--progress-size')) || 200;
    const lineWidth        = parseInt(getCSSVariable('--progress-line-width')) || 10;
    const levelNumberSize  = getCSSVariable('--level-number-size') || '48px';
    const progressBarColor = getCSSVariable('--progress-bar-color') || '#f00';

    const ctx = progressCanvas.getContext('2d');
    progressCanvas.width  = progressSize;
    progressCanvas.height = progressSize;

    const radius = progressSize / 2;

    // Пришло с бэка: startXP, nextXP, experience
    const experienceIntoLevel  = userData.experience - userData.startXP;
    const levelExperienceRange = userData.nextXP - userData.startXP;
    let progressPercent        = 0;
    if (levelExperienceRange > 0) {
      progressPercent = experienceIntoLevel / levelExperienceRange;
    }
    if (progressPercent < 0) progressPercent = 0;
    if (progressPercent > 1) progressPercent = 1;

    ctx.clearRect(0, 0, progressCanvas.width, progressCanvas.height);

    // Фон круга
    ctx.beginPath();
    ctx.arc(radius, radius, radius - lineWidth / 2, 0, 2 * Math.PI);
    ctx.strokeStyle = '#ccc';
    ctx.lineWidth   = lineWidth;
    ctx.lineCap     = 'round';
    ctx.stroke();

    // Прогресс
    ctx.beginPath();
    ctx.arc(
      radius,
      radius,
      radius - lineWidth / 2,
      -Math.PI / 2,
      -Math.PI / 2 + 2 * Math.PI * progressPercent
    );
    ctx.strokeStyle = progressBarColor;
    ctx.lineWidth   = lineWidth;
    ctx.lineCap     = 'round';
    ctx.stroke();

    userLevel.style.fontSize = levelNumberSize;
  }

  // Рендер мышечных карточек (теперь только 6 мышц, опыт без уровней)
  function renderMuscleCards() {
    const leftScreen  = document.querySelector('.left-screen');
    const rightScreen = document.querySelector('.right-screen');
    leftScreen.innerHTML  = '';
    rightScreen.innerHTML = '';

    const leftGrid  = document.createElement('div');
    leftGrid.className  = 'muscle-cards-grid';
    const rightGrid = document.createElement('div');
    rightGrid.className = 'muscle-cards-grid';

    
    // Из ответа бэка: userData.muscleExperience — массив объектов: [{name, experience}, ...]
    // Сформируем удобный для поиска объект: { 'Грудь': опыт, 'Спина': опыт, ... }
    const muscleExpMap = {};
    if (Array.isArray(userData.muscleExperience)) {
      userData.muscleExperience.forEach(m => {
        muscleExpMap[m.name] = m.experience;
      });
    }

    // Крупные
    bigMusclesList.forEach(muscle => {
      const card = createMuscleCard(muscle, muscleExpMap[muscle] || 0);
      leftGrid.appendChild(card);
    });
    // Мелкие
    smallMusclesList.forEach(muscle => {
      const card = createMuscleCard(muscle, muscleExpMap[muscle] || 0);
      rightGrid.appendChild(card);
    });

    leftScreen.appendChild(leftGrid);
    rightScreen.appendChild(rightGrid);
  }

  // Создание одной карточки для мышцы
  function createMuscleCard(muscleName, experience) {
    const card = document.createElement('div');
    card.className = 'muscle-card';

    const nameEl = document.createElement('div');
    nameEl.className = 'muscle-name';
    nameEl.textContent = muscleName;

    // Опыт
    const xpEl = document.createElement('div');
    xpEl.className = 'muscle-xp-text';
    xpEl.textContent = `Опыт: ${experience}`;

    // Иконка
    const iconEl = document.createElement('img');
    iconEl.className = 'muscle-icon';
    const iconFile = muscleIconsMap[muscleName] || 'default.png';
    iconEl.src = `/images/muscles/${iconFile}`;

    card.appendChild(nameEl);
    card.appendChild(xpEl);
    card.appendChild(iconEl);

    return card;
  }

  // Загрузка профиля с сервера
  async function loadUserProfile() {
    try {
      const response = await fetch('/getUserProfile');
      if (!response.ok) {
        console.error('Ошибка при загрузке данных пользователя.');
        return;
      }
      userData = await response.json(); // тут придёт nickname, level, startXP, nextXP, muscleExperience, etc.

      // Заполним UI
      userNickname.textContent = userData.nickname || '—';
      userLevel.textContent     = userData.level    || 1;

      // Расчитываем процент для цифры (не для круга), чтобы писать что-то вроде 75%
      const experienceIntoLevel  = userData.experience - userData.startXP;
      const levelExperienceRange = userData.nextXP - userData.startXP;
      let progressPercent        = 0;
      if (levelExperienceRange > 0) {
        progressPercent = Math.floor((experienceIntoLevel / levelExperienceRange) * 100);
        if (progressPercent < 0) progressPercent = 0;
        if (progressPercent > 100) progressPercent = 100;
      }
      levelProgressText.textContent = progressPercent + '%';

      drawProgressCircle();
      renderMuscleCards();
      updateArrowsVisibility();
    } catch (error) {
      console.error('Ошибка:', error);
    }
  }

  // Обработчик логаута
  logoutButton.addEventListener('click', async () => {
    try {
      const response = await fetch('/logout', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
      });
      if (response.ok) {
        // Было: window.location.href = '/login.html';
        // Стало (переходим на /login):
        window.location.href = '/login';
      } else {
        alert('Ошибка при выходе.');
      }
    } catch (error) {
      console.error('Ошибка:', error);
      alert('Произошла ошибка при выходе.');
    }
  });

  // Кнопка настроек
  settingsButton.addEventListener('click', () => {
    window.location.href = '/profile_settings';
  });

  workoutHistoryButton.addEventListener('click', () => {
    window.location.href = '/workouts';
  });

  measurementsButton.addEventListener('click', () => {
    window.location.href = '/measurements';
  });

  // Старт
  loadUserProfile();
});
