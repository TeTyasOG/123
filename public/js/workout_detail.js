document.addEventListener('DOMContentLoaded', async () => {
    const backButton = document.getElementById('backButton');
    const exercisesDiv = document.getElementById('exercises');
    const timeValue = document.getElementById('timeValue');
    const xpValue = document.getElementById('xpValue');
    const setsValue = document.getElementById('setsValue');
  
    const urlParams = new URLSearchParams(window.location.search);
    const workoutId = urlParams.get('id');
  
    if (!workoutId) {
      alert('Идентификатор тренировки не указан.');
      window.location.href = '/workouts.html';
      return;
    }
  
    // При нажатии назад переходим на workouts.html
    backButton.addEventListener('click', () => {
      window.location.href = '/workouts.html';
    });
  
    // Загрузка данных тренировки
    async function loadWorkoutData() {
      try {
        const response = await fetch(`/getWorkout?id=${workoutId}`);
        if (response.ok) {
          const workout = await response.json();
          displayWorkoutData(workout);
        } else {
          alert('Ошибка при загрузке данных тренировки.');
          window.location.href = '/workouts.html';
        }
      } catch (error) {
        console.error('Ошибка:', error);
        alert('Произошла ошибка при загрузке тренировки.');
        window.location.href = '/workouts.html';
      }
    }
  
    function displayWorkoutData(workout) {
      // Предполагаем, что workout имеет поля totalWorkoutTime, totalXP, totalSets
      // Если нет - нужно будет рассчитать.
      // Если нужно рассчитать опыт и сеты, можно сделать отдельно, но предположим, что сервер уже
      // возвращает totalWorkoutTime, totalXP, totalSets.
      const totalWorkoutTime = workout.totalWorkoutTime || '0С';
      const totalXP = workout.totalXP || 0;
      const totalSets = workout.totalSets || 0;
  
      timeValue.textContent = totalWorkoutTime;
      xpValue.textContent = `${totalXP} XP`;
      setsValue.textContent = totalSets;
  
      workout.exercises.forEach((exerciseEntry, exerciseIndex) => {
        addExercise(exerciseEntry, exerciseIndex);
      });
    }
  
    function addExercise(exerciseEntry, exerciseIndex) {
      // Форматируем данные упражнения
      const exercise = exerciseEntry.exerciseId;
      const sets = exerciseEntry.sets || [];
  
      const minWeight = exercise.minWeightMale || 20; 
      const maxWeight = exercise.maxWeightMale || 100;
  
      const exerciseItem = document.createElement('div');
      exerciseItem.className = 'exercise-item';
  
      exerciseItem.innerHTML = `
        <div class="exercise-header">
          <img class="exercise-image" src="${exercise.thumbnailUrl}" alt="${exercise.name}">
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
          <!-- Убрали "ПРЕД." колонку, теперь всего 5 столбцов -->
          <div class="header-item">ПОДХ.</div>
          <div class="header-item">КГ.</div>
          <div class="header-item">ПОВТ.</div>
          <div class="header-item">RPE</div>
          <div class="header-item"></div>
        </div>
        <div class="sets-list"></div>
      `;
  
      const setsList = exerciseItem.querySelector('.sets-list');
  
      sets.forEach((set, index) => {
        const setItem = document.createElement('div');
        setItem.className = 'set-item';
        setItem.innerHTML = `
          <div class="set-number">${index + 1}</div>
          <!-- Убрали "ПРЕД." и чекбокс -->
          <input type="number" class="input-weight" value="${set.weight}" disabled>
          <input type="number" class="input-reps" value="${set.reps}" disabled>
          <input type="number" class="input-rpe" value="${set.rpe}" disabled>
          <div class="set-action"></div>
        `;
        setsList.appendChild(setItem);
      });
  
      exercisesDiv.appendChild(exerciseItem);
    }
  
    await loadWorkoutData();
  });
  