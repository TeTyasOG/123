document.addEventListener('DOMContentLoaded', () => {

  const modalOverlay = document.getElementById('modalOverlay');
  const modalText = document.getElementById('modalText');
  const modalOkButton = document.getElementById('modalOkButton');
  const closeButton = document.getElementById('closeButton');
  const searchInput = document.getElementById('searchInput');
  const muscleFilterButton = document.getElementById('muscleFilterButton');
  const muscleFilterModal = document.getElementById('muscleFilterModal');
  const filterButton = document.getElementById('filterButton');
  const filterModal = document.getElementById('filterModal');
  const recentExercisesList = document.getElementById('recentExercisesList');
  const allExercisesList = document.getElementById('allExercisesList');
  const muscleOptions = muscleFilterModal.querySelectorAll('.muscle-option');
  const filterOptions = filterModal.querySelectorAll('.filter-option');
  const recentExercisesContainer = document.getElementById('recentExercisesContainer');
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  let selectedMuscleGroup = 'ВСЕ МЫШЦЫ';
  let selectedFilter = 'alphabetical'; 
  let exercises = [];
  let recentExercises = [];
  let userExerciseExperience = {};


  // Функция для отображения модального окна
  function showModal(text) {
    modalText.textContent = text;
    modalOverlay.style.display = 'block';

    // Закрытие окна по кнопке "ОК"
    modalOkButton.addEventListener('click', closeModal);

    // Закрытие окна при клике на фон
    modalOverlay.addEventListener('click', function overlayHandler(e) {
      if (e.target === modalOverlay) {
        closeModal();
        modalOverlay.removeEventListener('click', overlayHandler);
      }
    });
  }

  // Функция для закрытия модального окна
  function closeModal() {
    modalOverlay.style.display = 'none';
  }

  // Считываем, куда возвращаться после выбора упражнения
  const returnTo = sessionStorage.getItem('returnTo') || 'workout'; 

  // Кнопка закрытия
  closeButton.addEventListener('click', () => {
    window.history.back();
  });

  muscleFilterButton.addEventListener('click', () => {
    muscleFilterModal.style.display = 'block';
    muscleFilterModal.classList.add('modal-open');
  });

  filterButton.addEventListener('click', () => {
    filterModal.style.display = 'block';
    filterModal.classList.add('modal-open');
  });

  window.addEventListener('click', (event) => {
    if (event.target === muscleFilterModal) {
      muscleFilterModal.style.display = 'none';
      muscleFilterModal.classList.remove('modal-open');
    }
    if (event.target === filterModal) {
      filterModal.style.display = 'none';
      filterModal.classList.remove('modal-open');
    }
  });

  muscleOptions.forEach(option => {
    option.addEventListener('click', () => {
      selectedMuscleGroup = option.dataset.muscle;
      muscleFilterButton.textContent = selectedMuscleGroup;
      muscleFilterModal.style.display = 'none';
      muscleFilterModal.classList.remove('modal-open');
      updateMuscleFilterButtonAppearance();
      updateMuscleOptions();
      loadExercises();
    });
  });

  filterOptions.forEach(option => {
    option.addEventListener('click', () => {
      selectedFilter = option.dataset.filter;
      filterModal.style.display = 'none';
      filterModal.classList.remove('modal-open');
      updateFilterOptions();
      loadExercises();
    });
  });

  function updateMuscleOptions() {
    muscleOptions.forEach(option => {
      if (option.dataset.muscle === selectedMuscleGroup) {
        option.classList.add('selected');
      } else {
        option.classList.remove('selected');
      }
    });
  }

  function updateFilterOptions() {
    filterOptions.forEach(option => {
      if (option.dataset.filter === selectedFilter) {
        option.classList.add('selected');
      } else {
        option.classList.remove('selected');
      }
    });
  }

  function updateMuscleFilterButtonAppearance() {
    if (selectedMuscleGroup !== 'ВСЕ МЫШЦЫ') {
      muscleFilterButton.classList.add('muscle-selected');
    } else {
      muscleFilterButton.classList.remove('muscle-selected');
    }
  }

  searchInput.addEventListener('input', () => {
    loadExercises();
  });

  async function loadUserExerciseExperience() {
    try {
      const response = await fetch('/getUserProfile');
      if (!response.ok) throw new Error('Ошибка сети при получении профиля');
      const userData = await response.json();
      userExerciseExperience = userData.exerciseExperience || {};
    } catch (error) {
      console.error('Ошибка при загрузке данных пользователя:', error);
      showModal('Ошибка при загрузке данных пользователя.');
    }
  }

  async function loadExercises() {
    try {
      const searchQuery = searchInput.value.trim();
      // Передаём muscleGroup и searchQuery
      const url = new URL('/getExercises', window.location.origin);
      url.searchParams.append('searchQuery', searchQuery);

      // Если мы хотим фильтровать по мышцам (кроме "ВСЕ МЫШЦЫ"), передаём параметр muscleGroup
      if (selectedMuscleGroup !== 'ВСЕ МЫШЦЫ') {
        url.searchParams.append('muscleGroup', selectedMuscleGroup);
      }

      url.searchParams.append('sortType', selectedFilter); // Передаём выбранный тип сортировки
      const response = await fetch(url, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken, // Передаём токен
        },
        credentials: 'include', // Для отправки куки
      });
      

      if (!response.ok) throw new Error('Ошибка при получении упражнений');
      let allData = await response.json();

      // allData — уже массив объектов, где musclePercentages — объект { "Грудь": 50, "Спина": 50 }, и т.д.
      exercises = allData;

      await loadUserExerciseExperience();
      sortExercises();
      renderAllExercises();
      loadRecentExercises(selectedMuscleGroup, selectedFilter);
    } catch (error) {
      console.error('Ошибка при загрузке упражнений:', error);
      showModal('Ошибка при загрузке упражнений. Попробуйте позже.');
    }
  }

  async function loadRecentExercises(selectedMuscleGroup, selectedFilter) {
    try {
      const searchQuery = searchInput.value.trim();
      const url = new URL('/getRecentExercises', window.location.origin);
      if (searchQuery) {
        url.searchParams.append('searchQuery', searchQuery);
      }
      url.searchParams.append('sortType', selectedFilter); // Передаём выбранный тип сортировки
      const response = await fetch(url, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken, // Передаём токен
        },
        credentials: 'include', // Для отправки куки
      });
      

      if (!response.ok) throw new Error('Ошибка при получении последних упражнений');
      let allData = await response.json();

      // Фильтруем ещё раз по выбранной мышце
      if (selectedMuscleGroup !== 'ВСЕ МЫШЦЫ') {
        allData = allData.filter(ex => {
          const mp = ex.musclePercentages || {};
          // Собираем все названия мышц в верхнем регистре
          const muscles = Object.keys(mp).map(m => m.toUpperCase());
          return muscles.includes(selectedMuscleGroup.toUpperCase());
        });
      }

      recentExercises = allData;
      renderRecentExercises();
    } catch (error) {
      console.error('Ошибка при загрузке последних упражнений:', error);
      showModal('Ошибка при загрузке последних упражнений. Попробуйте позже.');
    }
  }

  function sortExercises() {
    if (selectedFilter === 'alphabetical') {
      exercises.sort((a, b) => (a.name || '').localeCompare(b.name || ''));
    } else if (selectedFilter === 'level') {
      exercises.sort((a, b) => {
        const levelA = a.userLevel || 0; // Уровень возвращается сервером
        const levelB = b.userLevel || 0;
        return levelB - levelA; // Сортировка по убыванию уровня
      });
    }
    
  }

  function renderAllExercises() {
    allExercisesList.innerHTML = '';
    exercises.forEach((exercise, index) => {
      const exerciseItem = createExerciseItem(exercise);
      allExercisesList.appendChild(exerciseItem);

      if (index < exercises.length - 1) {
        const separator = document.createElement('hr');
        separator.className = 'exercise-separator';
        allExercisesList.appendChild(separator);
      }
    });
  }

  function renderRecentExercises() {
    recentExercisesList.innerHTML = '';
    if (recentExercises.length === 0) {
      recentExercisesContainer.style.display = 'none';
      return;
    } else {
      recentExercisesContainer.style.display = 'block';
    }
    recentExercises.forEach((exercise, index) => {
      const exerciseItem = createExerciseItem(exercise);
      recentExercisesList.appendChild(exerciseItem);

      if (index < recentExercises.length - 1) {
        const separator = document.createElement('hr');
        separator.className = 'exercise-separator';
        recentExercisesList.appendChild(separator);
      }
    });
  }



  function getMainMuscle(exercise) {
    // musclePercentages — объект { 'Грудь': 80, 'Трицепс': 20, ... }
    const mp = exercise.musclePercentages || {};
    const entries = Object.entries(mp);
    if (entries.length === 0) return 'UNKNOWN';

    // Сортируем по величине процента
    entries.sort((a, b) => b[1] - a[1]);
    return (entries[0][0] || 'UNKNOWN').toUpperCase();
  }

  function createExerciseItem(exercise) {
    const exerciseItem = document.createElement('div');
    exerciseItem.className = 'exercise-item';

    const level = exercise.userLevel || 0;

    const rank = exercise.userRank || 'NONE';
    let rankHTML = '';
    if (rank === 'BRONZE') rankHTML = '<div class="level-indicator bronze"></div>';
    if (rank === 'SILVER') rankHTML = '<div class="level-indicator silver"></div>';
    if (rank === 'GOLD') rankHTML = '<div class="level-indicator gold"></div>';
    if (rank === 'DIAMOND') rankHTML = '<div class="level-indicator diamond"></div>';
    

    const exerciseName = (typeof exercise.name === 'string' && exercise.name.trim() !== '')
      ? exercise.name.toUpperCase()
      : 'UNKNOWN';

    const mainMuscle = getMainMuscle(exercise);

    exerciseItem.innerHTML = `
    <img src="${exercise.thumbnailUrl || '/default-thumbnail.png'}" alt="${exerciseName}" class="exercise-image">
    <div class="exercise-details">
      <div class="exercise-name">${exerciseName}</div>
      <div class="exercise-muscle">${mainMuscle}</div>
    </div>
    <div class="exercise-levels">${rankHTML}</div>
  `;
  

    const exerciseImage = exerciseItem.querySelector('.exercise-image');
    exerciseImage.addEventListener('click', (e) => {
      e.stopPropagation();
      window.location.href = 'exercise?id=' + exercise.id;
    });

    exerciseItem.addEventListener('click', () => {
      addExerciseToTarget(exercise);
    });

    return exerciseItem;
  }

  function addExerciseToTarget(exercise) {
    sessionStorage.setItem('selectedExercise', JSON.stringify(exercise));
    if (returnTo === 'program') {
      window.location.href = 'addProgram';
    } else {
      window.location.href = 'workout';
    }
  }

  async function init() {
    await loadUserExerciseExperience();
    updateFilterOptions();
    updateMuscleOptions();
    loadExercises();
  }

  init();
});
