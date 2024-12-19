document.addEventListener('DOMContentLoaded', () => {
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

  let selectedMuscleGroup = 'ВСЕ МЫШЦЫ';
  let selectedFilter = 'alphabetical'; 
  let exercises = [];
  let recentExercises = [];
  let userExerciseExperience = {};

  // Считываем куда возвращаться после выбора упражнения
  const returnTo = sessionStorage.getItem('returnTo') || 'workout'; 

  // Кнопка закрытия страницы
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
    }
  }

  async function loadExercises() {
    try {
      const searchQuery = searchInput.value.trim();
      const response = await fetch(`/getExercises?searchQuery=${encodeURIComponent(searchQuery)}`);
      if (!response.ok) throw new Error('Ошибка при получении упражнений');
      let allData = await response.json();

      let filteredData = allData;
      if (selectedMuscleGroup !== 'ВСЕ МЫШЦЫ') {
        filteredData = allData.filter(ex => {
          if (!ex.musclePercentages || typeof ex.musclePercentages !== 'object') return false;
          const muscles = Object.keys(ex.musclePercentages).map(m => m.toUpperCase());
          return muscles.includes(selectedMuscleGroup.toUpperCase());
        });
      }

      exercises = filteredData;
      await loadUserExerciseExperience();
      sortExercises();
      renderAllExercises();
      loadRecentExercises();
    } catch (error) {
      console.error('Ошибка при загрузке упражнений:', error);
    }
  }

  async function loadRecentExercises() {
    try {
      const searchQuery = searchInput.value.trim();
      const response = await fetch(`/getRecentExercises?searchQuery=${encodeURIComponent(searchQuery)}`);
      if (!response.ok) throw new Error('Ошибка при получении последних упражнений');
      let allData = await response.json();

      let filteredRecent = allData;
      if (selectedMuscleGroup !== 'ВСЕ МЫШЦЫ') {
        filteredRecent = allData.filter(ex => {
          if (!ex.musclePercentages || typeof ex.musclePercentages !== 'object') return false;
          const muscles = Object.keys(ex.musclePercentages).map(m => m.toUpperCase());
          return muscles.includes(selectedMuscleGroup.toUpperCase());
        });
      }

      recentExercises = filteredRecent;
      renderRecentExercises();
    } catch (error) {
      console.error('Ошибка при загрузке последних упражнений:', error);
    }
  }

  function sortExercises() {
    if (selectedFilter === 'alphabetical') {
      exercises.sort((a, b) => (a.name || '').localeCompare(b.name || ''));
    } else if (selectedFilter === 'level') {
      exercises.sort((a, b) => {
        const levelA = calculateExerciseLevel(a._id);
        const levelB = calculateExerciseLevel(b._id);
        return levelB - levelA;
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

  function calculateExerciseLevel(exerciseId) {
    const exp = Number(userExerciseExperience[exerciseId.toString()] || 0);
    return calcLevelFromXP(exp);
  }

  function calcLevelFromXP(experience) {
    if (experience >= 15000) {
      return 4; // Алмаз
    } else if (experience >= 7000) {
      return 3; // Золото
    } else if (experience >= 2500) {
      return 2; // Серебро
    } else if (experience >= 500) {
      return 1; // Бронза
    } else {
      return 0;
    }
  }

  function getMainMuscle(exercise) {
    if (!exercise.musclePercentages || typeof exercise.musclePercentages !== 'object' || Object.keys(exercise.musclePercentages).length === 0) {
      return 'UNKNOWN';
    }
    const entries = Object.entries(exercise.musclePercentages);
    entries.sort((a, b) => b[1] - a[1]);
    return (entries[0][0] || 'UNKNOWN').toUpperCase();
  }

  function createExerciseItem(exercise) {
    const exerciseItem = document.createElement('div');
    exerciseItem.className = 'exercise-item';

    const level = calculateExerciseLevel(exercise._id?.toString() || '');
    let levelHTML = '';
    if (level >= 1) levelHTML += '<div class="level-indicator bronze"></div>';
    if (level >= 2) levelHTML += '<div class="level-indicator silver"></div>';
    if (level >= 3) levelHTML += '<div class="level-indicator gold"></div>';
    if (level >= 4) levelHTML += '<div class="level-indicator diamond"></div>';

    const exerciseName = (typeof exercise.name === 'string' && exercise.name.trim() !== '') ? exercise.name.toUpperCase() : 'UNKNOWN';
    const mainMuscle = getMainMuscle(exercise);

    exerciseItem.innerHTML = `
      <img src="${exercise.thumbnailUrl || '/default-thumbnail.png'}" alt="${exerciseName}" class="exercise-image">
      <div class="exercise-details">
        <div class="exercise-name">${exerciseName}</div>
        <div class="exercise-muscle">${mainMuscle}</div>
      </div>
      <div class="exercise-levels">${levelHTML}</div>
    `;

    const exerciseImage = exerciseItem.querySelector('.exercise-image');
    exerciseImage.addEventListener('click', (e) => {
      e.stopPropagation();
      window.location.href = `exercise.html?id=${exercise._id}`;
    });

    exerciseItem.addEventListener('click', () => {
      addExerciseToTarget(exercise);
    });

    return exerciseItem;
  }

  // Добавление упражнения либо в программу, либо в тренировку
  function addExerciseToTarget(exercise) {
    sessionStorage.setItem('selectedExercise', JSON.stringify(exercise));
    if (returnTo === 'program') {
      window.location.href = 'addProgram.html';
    } else {
      window.location.href = 'workout.html';
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
