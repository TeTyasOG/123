
document.addEventListener('DOMContentLoaded', () => {
  const userNickname     = document.getElementById('userNickname');
  const userLevel        = document.getElementById('userLevel');
  const progressCanvas   = document.getElementById('progressCanvas');
  const logoutButton     = document.getElementById('logoutButton');
  const settingsButton   = document.getElementById('settingsButton');
  const workoutHistoryButton = document.getElementById('workoutHistoryButton');
  const measurementsButton   = document.getElementById('measurementsButton');
  const levelProgressText    = document.getElementById('levelProgressText');

  // Массивы мышц (пример, у вас 6 мышц)
  const bigMusclesList   = ['Грудь', 'Спина', 'Ноги'];
  const smallMusclesList = ['Плечи', 'Пресс', 'Руки'];

  // Карта иконок (пример). Подставьте свои картинки.
  const muscleIconsMap = {
    'Грудь':  'chest.png',
    'Спина':  'back.png',
    'Ноги':   'legs.png',
    'Плечи':  'shoulders.png',
    'Пресс':  'abs.png',
    'Руки':   'arms.png'
  };

  let userData = {}; // данные, загруженные с бэка
  
  // Блок переключения экранов
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

  // Свайпы на мобильных
  let startX = 0;
  let isSwiping = false;
  screensContainer.addEventListener('touchstart', (e) => {
    startX = e.touches[0].clientX;
    isSwiping = true;
  });
  screensContainer.addEventListener('touchmove', (e) => {
    if (!isSwiping) return;
    // Можно отслеживать движение, если нужно
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

  // Рисуем круговой прогресс "уровня игрока"
  function drawProgressCircle() {
    const progressSize     = parseInt(getCSSVariable('--progress-size')) || 200;
    const lineWidth        = parseInt(getCSSVariable('--progress-line-width')) || 10;
    const levelNumberSize  = getCSSVariable('--level-number-size') || '48px';
    const progressBarColor = getCSSVariable('--progress-bar-color') || '#f00';

    const ctx = progressCanvas.getContext('2d');
    progressCanvas.width  = progressSize;
    progressCanvas.height = progressSize;

    const radius = progressSize / 2;

    // startXP, nextXP, experience
    const experienceIntoLevel  = userData.experience - userData.startXP;
    const levelExperienceRange = userData.nextXP - userData.startXP;
    let progressPercent        = 0;
    if (levelExperienceRange > 0) {
      progressPercent = experienceIntoLevel / levelExperienceRange;
    }
    if (progressPercent < 0) progressPercent = 0;
    if (progressPercent > 1) progressPercent = 1;

    ctx.clearRect(0, 0, progressCanvas.width, progressCanvas.height);

    // Фон круга (серый)
    ctx.beginPath();
    ctx.arc(radius, radius, radius - lineWidth / 2, 0, 2 * Math.PI);
    ctx.strokeStyle = '#ccc';
    ctx.lineWidth   = lineWidth;
    ctx.lineCap     = 'round';
    ctx.stroke();

    // Прогресс (цветной круг)
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

    // Размер цифры уровня внутри круга
    userLevel.style.fontSize = levelNumberSize;
  }

  /**
   * Рендерим карточки мышц.
   * Теперь вместо цифр опыта показываем уровень,
   * а ниже — горизонтальный прогресс бар до следующего уровня.
   */
  function renderMuscleCards() {
    const leftScreen  = document.querySelector('.left-screen');
    const rightScreen = document.querySelector('.right-screen');
    leftScreen.innerHTML  = '';
    rightScreen.innerHTML = '';

    const leftGrid  = document.createElement('div');
    leftGrid.className  = 'muscle-cards-grid';
    const rightGrid = document.createElement('div');
    rightGrid.className = 'muscle-cards-grid';

    // Преобразуем userData.muscleExperience в удобную мапу: { 'Грудь': {...}, 'Спина': {...}, ... }
    // Там теперь есть: { name, level, startXP, nextXP }
    const muscleMap = {};
    if (Array.isArray(userData.muscleExperience)) {
      userData.muscleExperience.forEach(m => {
        muscleMap[m.name] = {
          level:   m.level,
          startXP: m.startXP,
          nextXP:  m.nextXP
        };
      });
    }

    // Крупные мышцы
    bigMusclesList.forEach(muscle => {
      const muscleData = muscleMap[muscle] || { level: 1, startXP: 0, nextXP: 500 };
      const card = createMuscleCard(muscle, muscleData);
      leftGrid.appendChild(card);
    });
    // Мелкие мышцы
    smallMusclesList.forEach(muscle => {
      const muscleData = muscleMap[muscle] || { level: 1, startXP: 0, nextXP: 500 };
      const card = createMuscleCard(muscle, muscleData);
      rightGrid.appendChild(card);
    });

    leftScreen.appendChild(leftGrid);
    rightScreen.appendChild(rightGrid);
  }

  /**
   * Создаём одну карточку для мышцы.
   * Внутри:
   *  - Название мышцы
   *  - Иконка
   *  - Текст "Уровень: X"
   *  - Горизонтальная полоска прогресса (процент)
   */
  function createMuscleCard(muscleName, muscleData) {
    const { level, startXP, nextXP } = muscleData;

    // Для прогресса — вычислим, как далеко мы зашли в "текущий" уровень
    // По аналогии с уровнем персонажа, нужен опыт мышц. Но на фронте у нас нет «актуального» experience,
    // так что (startXP, nextXP) — это границы. А весь «опыт мышцы» = ... уже учтён на бэке.
    // У нас нет rawExp, но мы можем условно сказать, что уже достигли startXP (по определению), 
    // а от startXP до nextXP — 0..1. Но для показа прогресса мышц достаточно 0%, т.к. формулу мы упростили :)
    //
    // Однако, если нужно точнее, то придётся бэк менять, чтобы прислать "muscleExp" отдельно. 
    // Тогда progress = (muscleExp - startXP) / (nextXP - startXP).
    // Для наглядности сделаем вариант (если нужно) => добавим сырое поле:
    //   muscleExp: (rawExp)
    // В таком случае надо изменить getUserProfile -> map(...), где вернём 'muscleExp' => $muscle->pivot->experience
    // и тут его используем. 
    // Для примера считаем, что бэк вернёт: 'muscleExp' => $muscle->pivot->experience
    // И тогда:
    // progressPercent = (muscleExp - startXP) / (nextXP - startXP)
    // (см. чуть ниже)
    
    // Для корректности добавим этот шаг:
    let muscleExp = 0;
    // Проверим, не отдали ли мы "muscleExp" дополнительно:
    if (userData.muscleExperience) {
      // Находим запись
      const found = userData.muscleExperience.find(m => m.name === muscleName);
      if (found && typeof found.muscleExp === 'number') {
        muscleExp = found.muscleExp;
      }
    }
    // Считаем прогресс
    let progressPercent = 0;
    const range = nextXP - startXP;
    if (range > 0 && muscleExp > 0) {
      progressPercent = (muscleExp - startXP) / range;
    }
    if (progressPercent < 0) progressPercent = 0;
    if (progressPercent > 1) progressPercent = 1;
    progressPercent = Math.floor(progressPercent * 100);

    // Обёртка-карточка
    const card = document.createElement('div');
    card.className = 'muscle-card';

    // Название мышцы
    const nameEl = document.createElement('div');
    nameEl.className = 'muscle-name';
    nameEl.textContent = muscleName;

    // Иконка
    const iconEl = document.createElement('img');
    iconEl.className = 'muscle-icon';
    const iconFile = muscleIconsMap[muscleName] || 'default.png';
    iconEl.src = `/images/muscles/${iconFile}`;

    // Блок "Уровень: X"
    const levelEl = document.createElement('div');
    levelEl.className = 'muscle-level-text';
    levelEl.textContent = `Уровень: ${level}`;

    // Горизонтальный прогресс-бар
    const progressBarContainer = document.createElement('div');
    progressBarContainer.className = 'muscle-progress-bar-container';

    const progressBar = document.createElement('div');
    progressBar.className = 'muscle-progress-bar';
    progressBar.style.width = progressPercent + '%';

    progressBarContainer.appendChild(progressBar);

    card.appendChild(nameEl);
    card.appendChild(iconEl);
    card.appendChild(levelEl);
    card.appendChild(progressBarContainer);

    return card;
  }

  // Загрузка профиля
  async function loadUserProfile() {
    try {
      const response = await fetch('/getUserProfile');
      if (!response.ok) {
        console.error('Ошибка при загрузке данных пользователя с /getUserProfile.');
        return;
      }
      userData = await response.json(); 
      // Ожидаем:
      // userData = {
      //   nickname, gender, weight,
      //   experience, level, startXP, nextXP,
      //   muscleExperience: [
      //       { name, level, startXP, nextXP },
      //       ...
      //   ]
      // }

      // Заполним UI
      userNickname.textContent = userData.nickname || '—';
      userLevel.textContent     = userData.level    || 1;

      // Текстовый прогресс в %
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
      console.error('Ошибка при загрузке профиля:', error);
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

  // Инициируем стартовую загрузку
  loadUserProfile();
});

