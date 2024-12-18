document.addEventListener('DOMContentLoaded', () => {
    const userNickname = document.getElementById('userNickname');
    const userLevel = document.getElementById('userLevel');
    const progressCanvas = document.getElementById('progressCanvas');
    const achievementList = document.getElementById('achievementList');
  
    const logoutButton = document.getElementById('logoutButton');
    const settingsButton = document.getElementById('settingsButton');
    const workoutHistoryButton = document.getElementById('workoutHistoryButton');
    const measurementsButton = document.getElementById('measurementsButton');
  
    let userData = {};
  
    const bigMusclesList = ['Грудь', 'Ноги', 'Плечи', 'Спина', 'Ягодицы', 'Бицепс'];
    const smallMusclesList = ['Пресс', 'Трапеции', 'Икры', 'Подколенные', 'Трицепс', 'Предплечья'];
  
    function getCSSVariable(name) {
      return getComputedStyle(document.documentElement).getPropertyValue(name).trim();
    }
  
    function getExperienceRangeForLevel(level) {
      if (level <= 20) {
        const startXP = 200 * (level - 1) + 300;
        const nextXP = 200 * level + 300;
        return { startXP, nextXP };
      } else if (level <= 70) {
        const startXP = 8600 + Math.pow(level - 21, 1.5) * 12;
        const nextXP = 8600 + Math.pow(level - 20, 1.5) * 12;
        return { startXP, nextXP };
      } else {
        const startXP = 1800000 + 30000 * Math.pow(1.08, level - 71);
        const nextXP = 1800000 + 30000 * Math.pow(1.08, level - 70);
        return { startXP, nextXP };
      }
    }
  
    function calculateLevelProgress(experience, level) {
      const { startXP, nextXP } = getExperienceRangeForLevel(level);
      const experienceIntoLevel = experience - startXP;
      const levelExperienceRange = nextXP - startXP;
      const progressPercent = Math.min(Math.floor((experienceIntoLevel / levelExperienceRange) * 100), 100);
      return progressPercent;
    }
  
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
  
    // Маппинг иконок
    const muscleIconsMap = {
      'Грудь': 'chest.png',
      'Ноги': 'legs.png',
      'Плечи': 'shoulders.png',
      'Спина': 'back.png',
      'Ягодицы': 'glutes.png',
      'Бицепс': 'biceps.png',
      'Пресс': 'abs.png',
      'Трапеции': 'traps.png',
      'Икры': 'calves.png',
      'Подколенные': 'hamstrings.png',
      'Трицепс': 'triceps.png',
      'Предплечья': 'forearms.png'
    };
  
    function calculateXPForLevel(level) {
      const A = 50;
      const B = 500;
      return A * level ** 2 + B;
    }
  
    function calculateMuscleProgressData(level, experience) {
      let totalXPForCurrentLevel = 0;
      for (let i = 1; i < level; i++) {
        totalXPForCurrentLevel += calculateXPForLevel(i);
      }
      const xpForNextLevel = calculateXPForLevel(level);
      const experienceIntoLevel = experience - totalXPForCurrentLevel;
      const progressPercent = Math.min((experienceIntoLevel / xpForNextLevel) * 100, 100);
  
      return {
        currentXP: experienceIntoLevel,
        neededXP: xpForNextLevel,
        progressPercent: progressPercent
      };
    }
  
    function renderMuscleCards() {
      const leftScreen = document.querySelector('.left-screen');
      const rightScreen = document.querySelector('.right-screen');
  
      leftScreen.innerHTML = '';
      rightScreen.innerHTML = '';
  
      const leftGrid = document.createElement('div');
      leftGrid.className = 'muscle-cards-grid';
  
      const rightGrid = document.createElement('div');
      rightGrid.className = 'muscle-cards-grid';
  
      bigMusclesList.forEach(muscle => {
        const card = createMuscleCard(muscle);
        leftGrid.appendChild(card);
      });
  
      smallMusclesList.forEach(muscle => {
        const card = createMuscleCard(muscle);
        rightGrid.appendChild(card);
      });
  
      leftScreen.appendChild(leftGrid);
      rightScreen.appendChild(rightGrid);
    }
  
    function createMuscleCard(muscle) {
      const muscleLevel = userData.muscleLevels[muscle] || 1;
      const muscleExperience = userData.muscleExperience[muscle] || 0;
      const progressData = calculateMuscleProgressData(muscleLevel, muscleExperience);
  
      const card = document.createElement('div');
      card.className = 'muscle-card';
  
      const nameEl = document.createElement('div');
      nameEl.className = 'muscle-name';
      nameEl.textContent = muscle;
  
      const levelEl = document.createElement('div');
      levelEl.className = 'muscle-level-text';
      levelEl.textContent = `Уровень: ${muscleLevel}`;
  
      const iconEl = document.createElement('img');
      iconEl.className = 'muscle-icon';
      const iconFile = muscleIconsMap[muscle] || 'default.png'; 
      iconEl.src = `images/muscles/${iconFile}`;
  
      const progressContainer = document.createElement('div');
      progressContainer.className = 'progress-bar-container';
  
      const progressFill = document.createElement('div');
      progressFill.className = 'progress-bar-fill';
      progressFill.style.width = progressData.progressPercent + '%'; 
  
      progressContainer.appendChild(progressFill);
  
      card.appendChild(nameEl);
      card.appendChild(levelEl);
      card.appendChild(iconEl);
      card.appendChild(progressContainer);
  
      return card;
    }
  
    async function loadUserProfile() {
      try {
        const response = await fetch('/getUserProfile');
        if (response.ok) {
          const user = await response.json();
          userData = user;
  
          const allMuscles = [...bigMusclesList, ...smallMusclesList];
          allMuscles.forEach(muscle => {
            if (!userData.muscleLevels[muscle]) userData.muscleLevels[muscle] = 1;
            if (!userData.muscleExperience[muscle]) userData.muscleExperience[muscle] = 0;
          });
  
          const progressPercent = calculateLevelProgress(userData.experience, userData.level);
          updateUserProfileUI(progressPercent);
          updateArrowsVisibility();
          renderMuscleCards();
  
        } else {
          console.error('Ошибка при загрузке данных пользователя.');
        }
      } catch (error) {
        console.error('Ошибка:', error);
      }
    }
  
    function updateUserProfileUI(progressPercent) {
      userNickname.textContent = userData.nickname || '—';
      userLevel.textContent = userData.level || 1;
  
      const levelProgressText = document.getElementById('levelProgressText');
      levelProgressText.textContent = `${progressPercent}%`;
  
      drawProgressCircle();
  
      if (achievementList) {
        achievementList.innerHTML = '<div class="empty-achievements">ПОКА ТУТ ПУСТО</div>';
      }
    }
  
    function drawProgressCircle() {
      const progressSize = parseInt(getCSSVariable('--progress-size'));
      const lineWidth = parseInt(getCSSVariable('--progress-line-width'));
      const levelNumberSize = getCSSVariable('--level-number-size');
      const progressBarColor = getCSSVariable('--progress-bar-color');
  
      progressCanvas.width = progressSize;
      progressCanvas.height = progressSize;
  
      const ctx = progressCanvas.getContext('2d');
      const radius = progressSize / 2;
  
      const { startXP, nextXP } = getExperienceRangeForLevel(userData.level);
      const experienceIntoLevel = userData.experience - startXP;
      const levelExperienceRange = nextXP - startXP;
      const progressPercent = experienceIntoLevel / levelExperienceRange;
  
      ctx.clearRect(0, 0, progressCanvas.width, progressCanvas.height);
  
      // Фон круга
      ctx.beginPath();
      ctx.arc(radius, radius, radius - lineWidth / 2, 0, 2 * Math.PI);
      ctx.strokeStyle = '#ccc';
      ctx.lineWidth = lineWidth;
      ctx.lineCap = 'round';
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
      ctx.lineWidth = lineWidth;
      ctx.lineCap = 'round';
      ctx.stroke();
  
      userLevel.style.fontSize = levelNumberSize;
    }
  
    // Удаляем все ссылки на muscleLevelsModal и модальное окно
    // Удаляем все связанные функции и обработчики, связанные с модальным окном уровней мышц.
  
    logoutButton.addEventListener('click', async () => {
      try {
        const response = await fetch('/logout', { method: 'POST' });
        if (response.ok) {
          alert('Вы успешно вышли из системы.');
          window.location.href = '/login.html';
        } else {
          alert('Ошибка при выходе.');
        }
      } catch (error) {
        console.error('Ошибка:', error);
        alert('Произошла ошибка при выходе.');
      }
    });
  
    settingsButton.addEventListener('click', () => {
      window.location.href = '/profile_settings.html';
    });
  
    workoutHistoryButton.addEventListener('click', () => {
      window.location.href = '/workouts.html';
    });
  
    measurementsButton.addEventListener('click', () => {
      window.location.href = '/measurements.html';
    });
  
    // Загрузка данных профиля
    loadUserProfile();
  });
  