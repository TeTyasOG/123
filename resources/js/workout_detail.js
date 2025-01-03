document.addEventListener('DOMContentLoaded', async () => {
  const modalOverlay = document.getElementById('modalOverlay');
  const modalText = document.getElementById('modalText');
  const modalOkButton = document.getElementById('modalOkButton');
  const backButton = document.getElementById('backButton');
  const exercisesDiv = document.getElementById('exercises');
  const timeValue = document.getElementById('timeValue');
  const xpValue = document.getElementById('xpValue');
  const setsValue = document.getElementById('setsValue');

  const urlParams = new URLSearchParams(window.location.search);
  const workoutId = urlParams.get('id');

  function showModal(text, redirectUrl = null) {
    modalText.textContent = text;
    modalOverlay.style.display = 'block';

    modalOkButton.onclick = () => {
      closeModal();
      if (redirectUrl) {
        window.location.href = redirectUrl;
      }
    };

    modalOverlay.onclick = (e) => {
      if (e.target === modalOverlay) {
        closeModal();
      }
    };
  }

  function closeModal() {
    modalOverlay.style.display = 'none';
  }

  if (!workoutId) {
    showModal('Идентификатор тренировки не указан.', '/workouts');
    return;
  }
  

  // При нажатии назад переходим на workouts
  backButton.addEventListener('click', () => {
    window.location.href = '/workouts';
  });

  // Загрузка данных тренировки
  async function loadWorkoutData() {
    try {
      // Меняем URL, который возвращает JSON
      const response = await fetch(`/getWorkout?id=${workoutId}`);
      if (response.ok) {
        const workout = await response.json();
        displayWorkoutData(workout);
      } else {
        showModal('Ошибка при загрузке данных тренировки.', '/workouts');
      }
    } catch (error) {
      console.error('Ошибка:', error);
      showModal('Произошла ошибка при загрузке тренировки.', '/workouts');
    }
  }

  function displayWorkoutData(workout) {
    // В контроллере мы возвращаем:
    // - total_workout_time
    // - total_experience
    // - exercises_count (необязательно для отображения, но есть)
    // - exercises (массив)

    // Подставляем эти данные
    const totalWorkoutTime = workout.total_workout_time || '0с';
    const totalXP = workout.total_experience || 0;

    // Если у вас нет поля totalSets на бэкенде, можно вычислить суммарное количество подходов:
    // например, суммируя все sets_count, или — каждый set из массива.
    let totalSets = 0;
    if (workout.exercises && Array.isArray(workout.exercises)) {
      workout.exercises.forEach(ex => {
        // Можно либо взять sets_count
        totalSets += ex.sets_count || 0;
        // Или пробежаться по ex.sets
        // totalSets += ex.sets ? ex.sets.length : 0;
      });
    }

    // Заполняем DOM
    timeValue.textContent = totalWorkoutTime;  // "45m"
    xpValue.textContent = `${totalXP} XP`;     // "50 XP"
    setsValue.textContent = totalSets;         // 6, 10 и т.п.

    // Выводим список упражнений
    if (workout.exercises && Array.isArray(workout.exercises)) {
      workout.exercises.forEach((exerciseEntry, exerciseIndex) => {
        addExercise(exerciseEntry, exerciseIndex);
      });
    }
  }

  function addExercise(exerciseEntry, exerciseIndex) {
    // В новом формате данные об упражнении лежат в exerciseEntry.exercise
    const exercise = exerciseEntry.exercise;
    if (!exercise) {
      console.warn('У упражнения нет данных (exercise === null).');
      return;
    }

    // Список подходов хранится в exerciseEntry.sets
    const sets = exerciseEntry.sets || [];

    // Если нужен minWeight / maxWeight
    const minWeight = exercise.min_weight_male || 20;
    const maxWeight = exercise.max_weight_male || 100;

    const exerciseItem = document.createElement('div');
    exerciseItem.className = 'exercise-item';

    // Генерируем HTML
    exerciseItem.innerHTML = `
      <div class="exercise-header">
        <img class="exercise-image" src="${exercise.thumbnail_url}" alt="${exercise.name}">
        <div class="exercise-details">
          <div class="exercise-name">${exercise.name}</div>
          <div class="exercise-info">
            <div class="info-item">
              <span>1</span>
              <img src="images/icons/xp_sphere.png" alt="XP">
              <span>- ${Math.round(minWeight)} КГ</span>
            </div>
            <div class="info-separator">|</div>
            <div class="info-item">
              <span>10</span>
              <img src="images/icons/xp_sphere.png" alt="XP">
              <span>- ${Math.round(maxWeight)} КГ</span>
            </div>
          </div>
        </div>
      </div>
      <hr class="small-separator">
      <div class="sets-header">
        <div class="header-item">ПОДХ.</div>
        <div class="header-item">КГ.</div>
        <div class="header-item">ПОВТ.</div>
        <div class="header-item">RPE</div>
        <div class="header-item"></div>
      </div>
      <div class="sets-list"></div>
    `;

    const setsList = exerciseItem.querySelector('.sets-list');

    // Заполняем подходы
    sets.forEach((set, index) => {
      const setItem = document.createElement('div');
      setItem.className = 'set-item';
      setItem.innerHTML = `
        <div class="set-number">${index + 1}</div>
        <input type="number" class="input-weight" value="${set.weight}" disabled>
        <input type="number" class="input-reps" value="${set.reps}" disabled>
        <input type="number" class="input-rpe" value="${set.rpe}" disabled>
        <div class="set-action"></div>
      `;
      setsList.appendChild(setItem);
    });

    // --- Добавляем возможность перехода на страницу упражнения по клику на картинку ---
    const exerciseImage = exerciseItem.querySelector('.exercise-image');
    exerciseImage.addEventListener('click', (e) => {
      e.stopPropagation(); 
      // Переход на страницу упражнения
      window.location.href = `exercise?id=${exercise.id}`;
    });
    // -------------------------------------------------------------------------------

    exercisesDiv.appendChild(exerciseItem);
  }

  // Загружаем данные
  await loadWorkoutData();
});
