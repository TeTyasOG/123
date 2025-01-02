document.addEventListener('DOMContentLoaded', async () => {
  const backButton          = document.getElementById('backButton');
  const finishButton        = document.getElementById('finishButton');
  const addExerciseButton   = document.getElementById('addExerciseButton');
  const deleteWorkoutButton = document.getElementById('deleteWorkoutButton');
  const exercisesDiv        = document.getElementById('exercises');

  const timeValue = document.getElementById('timeValue');
  const xpValue   = document.getElementById('xpValue');
  const setsValue = document.getElementById('setsValue');

  let workoutStartTime   = new Date();
  let workoutInterval    = null;
  let totalXP            = 0;
  let totalSetsCompleted = 0;
  let workoutExercises   = []; // Храним [{ id, name, sets, notes }]
  let userData           = {};
  let isProgramStart     = false;

// Флажок, говорящий: «Пропустить загрузку предыдущих сетов при первом отображении»
let skipPreviousSets = sessionStorage.getItem('skipPreviousSets') === 'true';
if (skipPreviousSets) {
  console.log('Первый запуск по программе: пропускаем загрузку прошлых сетов');
}

  // При добавлении упражнения (с другой страницы) вернёмся сюда
  sessionStorage.setItem('returnTo', 'workout');

  // 1) Загружаем данные пользователя
  await loadUserData();
  // 2) Восстанавливаем тренировку из sessionStorage (если есть)
  await loadWorkoutState();

  /** Кнопка «Назад» */
  backButton.addEventListener('click', () => {
    window.location.href = 'training';
  });

  /** Кнопка «Завершить тренировку» */
  finishButton.addEventListener('click', () => {
    if (hasIncompleteSets()) {
      alert('Есть невыполненные сеты. Завершите или удалите их прежде чем закончить тренировку.');
      return;
    }
    openConfirmationModal('Вы точно хотите завершить тренировку?', () => {
      clearInterval(workoutInterval);
      saveWorkout(); // отправляем на сервер
    }, () => {});
  });

  /** Кнопка «Добавить упражнение» */
  addExerciseButton.addEventListener('click', () => {
    saveWorkoutState();
    window.location.href = 'addExercise'; // страница выбора упражнения
  });

  /** Кнопка «Удалить тренировку» (полностью) */
  deleteWorkoutButton.addEventListener('click', () => {
    openConfirmationModal('Вы точно хотите удалить тренировку?', () => {
      sessionStorage.clear();
      window.location.href = 'training';
    }, () => {});
  });

  /** Если вернулись с выбранным упражнением */
  const selectedExerciseJSON = sessionStorage.getItem('selectedExercise');
  if (selectedExerciseJSON) {
    const selectedExercise = JSON.parse(selectedExerciseJSON);
    await addExerciseToWorkout(selectedExercise);
    sessionStorage.removeItem('selectedExercise');
    saveWorkoutState();
  }

  /**
   * Проверка на незавершённые (не «completed») сеты
   */
  function hasIncompleteSets() {
    updateWorkoutExercisesFromDOM();
    for (const ex of workoutExercises) {
      for (const st of ex.sets) {
        if (!st.completed) {
          return true;
        }
      }
    }
    return false;
  }

  /**
   * Загрузка профиля пользователя (нужна для расчётов веса, пола и т.д.)
   */
  async function loadUserData() {
    try {
      // ВАЖНО: credentials: 'include' чтобы куки сессии передавались
      const response = await fetch('/getUserProfile', {
        method: 'GET',
        credentials: 'include'
      });
      if (!response.ok) {
        throw new Error(`Ошибка при загрузке профиля пользователя (код ${response.status})`);
      }
      userData = await response.json();
      console.log('Данные пользователя загружены:', userData);
    } catch (error) {
      console.error('Ошибка при загрузке данных пользователя:', error);
    }
  }

  /**
   * Восстанавливаем данные тренировки из sessionStorage
   */
  async function loadWorkoutState() {
    const workoutStateJSON = sessionStorage.getItem('workoutState');
    if (workoutStateJSON) {
      
        const workoutState = JSON.parse(workoutStateJSON);
        workoutStartTime   = new Date(workoutState.workoutStartTime);
        totalXP            = workoutState.totalXP || 0;
        totalSetsCompleted = workoutState.totalSetsCompleted || 0;
        workoutExercises   = workoutState.workoutExercises || [];

  
        for (const ex of workoutExercises) {
          const fullExData = await loadFullExerciseData(ex); // Загружаем недостающие данные
          console.log(`loadWorkoutState: Загруженные данные для упражнения ${ex.id}: ${JSON.stringify(fullExData)}`);
          Object.assign(ex, fullExData);
      }
      
        
        exercisesDiv.innerHTML = workoutState.exercisesHTML || '';

        xpValue.textContent   = `${Math.round(totalXP)} XP`;
        setsValue.textContent = totalSetsCompleted;

        // Восстанавливаем значения полей КГ, ПОВТ и RPE
        workoutExercises.forEach(exercise => {
            const exerciseItem = exercisesDiv.querySelector(`[data-exercise-id="${exercise.id}"]`);
            if (exerciseItem) {
                const setsList = exerciseItem.querySelectorAll('.set-item');
                exercise.sets.forEach((set, index) => {
                    const setItem = setsList[index];
                    if (setItem) {
                        const weightInput = setItem.querySelector('.input-weight');
                        const repsInput   = setItem.querySelector('.input-reps');
                        const rpeInput    = setItem.querySelector('.input-rpe');

                        weightInput.value = set.weight;
                        repsInput.value   = set.reps;
                        rpeInput.value    = set.rpe;
                    }
                });
            }
        });

        restoreExerciseEventListeners();
        startWorkoutTimer();
    } else {
        // Инициализация при первой загрузке страницы
        workoutStartTime   = new Date();
        totalXP            = 0;
        totalSetsCompleted = 0;
        workoutExercises   = [];
        exercisesDiv.innerHTML = '';
        xpValue.textContent   = '0 XP';
        setsValue.textContent = '0';
        startWorkoutTimer();
    
      // Если тренировка начата «по программе»
      const currentProgram = sessionStorage.getItem('currentProgramWorkout');
      if (currentProgram) {
        const programData = JSON.parse(currentProgram);
        isProgramStart = true;
        for (const pEx of programData.exercises) {
          const exerciseId = pEx.exerciseId;
          const setsCount  = pEx.sets;
          const repsCount  = pEx.reps;

          const exerciseResponse = await fetch(`/exerciseInfo?id=${exerciseId}`, {
            credentials: 'include'
          });
          if (exerciseResponse.ok) {
            const exData = await exerciseResponse.json();
            // Гарантируем, что используем exData.id, а не _id
            if (!exData.id && exData._id) {
              exData.id = exData._id;
            }
            await addExerciseToWorkoutFromProgram(exData, setsCount, repsCount);
          } else {
            console.error('Failed to load exercise info for program exercise:', exerciseId);
          }
        }
        saveWorkoutState();
      } else {
        isProgramStart = false;
      }
      startWorkoutTimer();
    }
  }

  /**
   * Запускаем таймер (общее время тренировки)
   */
  function startWorkoutTimer() {
    if (workoutInterval) clearInterval(workoutInterval);
    workoutInterval = setInterval(() => {
      const now = new Date();
      const elapsed = new Date(now - workoutStartTime);
      const hours   = elapsed.getUTCHours();
      const minutes = elapsed.getUTCMinutes();
      const seconds = elapsed.getUTCSeconds();

      let timeString = '';
      if (hours > 0) {
        timeString += `${hours}Ч `;
      }
      if (minutes > 0 || hours > 0) {
        timeString += `${minutes}М `;
      }
      timeString += `${seconds}С`;

      timeValue.textContent = timeString;
    }, 1000);
  }

  /**
   * Сохраняем текущее состояние тренировки в sessionStorage
   */
  function saveWorkoutState() {
    const workoutState = {
        workoutStartTime: workoutStartTime.toISOString(),
        totalXP,
        totalSetsCompleted,
        workoutExercises: workoutExercises.map(ex => ({
            id: ex.id,
            name: ex.name,
            sets: ex.sets,
            notes: ex.notes,
            minWeightMale: ex.minWeightMale,
maxWeightMale: ex.maxWeightMale,
minWeightFemale: ex.minWeightFemale,
maxWeightFemale: ex.maxWeightFemale,

        })),
        exercisesHTML: exercisesDiv.innerHTML
    };
    sessionStorage.setItem('workoutState', JSON.stringify(workoutState));
}


  /**
   * Собираем из DOM (exercisesDiv) актуальные данные в workoutExercises
   */
  console.log('Пересчёт XP и обновление DOM...');

  function updateWorkoutExercisesFromDOM() {
    const newWorkoutExercises = [];
    const exerciseItems = exercisesDiv.querySelectorAll('.exercise-item');

    exerciseItems.forEach(exerciseItem => {
        const exId   = exerciseItem.dataset.exerciseId;
        const exName = exerciseItem.dataset.exerciseName;
        const notes  = exerciseItem.querySelector('.exercise-notes')?.value || '';

        const sets = [];
        const setsList = exerciseItem.querySelectorAll('.set-item');
        setsList.forEach(setItem => {
            const weightInput = setItem.querySelector('.input-weight');
            const repsInput   = setItem.querySelector('.input-reps');
            const rpeInput    = setItem.querySelector('.input-rpe');
            const completed   = setItem.classList.contains('completed');

            let wVal = parseFloat(weightInput.value);
            if (isNaN(wVal)) wVal = 0;
            wVal = Math.round(wVal);

            let rVal = parseInt(repsInput.value);
            if (isNaN(rVal)) rVal = 0;

            let rpeVal = parseInt(rpeInput.value);
            if (isNaN(rpeVal)) rpeVal = 5;

            sets.push({ weight: wVal, reps: rVal, rpe: rpeVal, completed });

            // Добавляем слушатели для сохранения данных
            weightInput.addEventListener('input', saveWorkoutState);
            repsInput.addEventListener('input', saveWorkoutState);
            rpeInput.addEventListener('input', saveWorkoutState);
        });

        newWorkoutExercises.push({
            id: exId,
            name: exName,
            sets,
            notes
        });
    });
    workoutExercises = newWorkoutExercises;
    console.log('Синхронизация данных из DOM в workoutExercises завершена:', workoutExercises);
}


  /**
   * Восстанавливаем слушатели событий (на сетах, кнопках и т.п.)
   */
  function restoreExerciseEventListeners() {
    console.log('Восстановление обработчиков событий для упражнений...');
    const exerciseItems = exercisesDiv.querySelectorAll('.exercise-item');
    exerciseItems.forEach(exerciseItem => {
      const exerciseId   = exerciseItem.dataset.exerciseId;
      const addSetButton = exerciseItem.querySelector('.add-set-button');
      const setsList     = exerciseItem.querySelector('.sets-list');
      const notesTextarea = exerciseItem.querySelector('.exercise-notes');
      const exerciseSettingsButton = exerciseItem.querySelector('.exercise-settings-button');
      const exerciseImage = exerciseItem.querySelector('.exercise-image');
      console.log(`Добавляем обработчики для упражнения с ID: ${exerciseId}`);
  
      // Убедимся, что кнопка "Добавить сет" добавляет новый сет
      addSetButton.addEventListener('click', async () => {
        console.log('Кнопка "Добавить сет" нажата для упражнения:', exerciseId);
        // ВАЖНО: parseInt, если ID — число
        const exIdNum = parseInt(exerciseId);
        const exObj = workoutExercises.find(ex => ex.id === exIdNum);
        if (!exObj) {
          console.error('Упражнение не найдено. Возможно, exerciseId и ex.id имеют разные типы.');
          return;
        }
  if (skipPreviousSets) {
    skipPreviousSets = false;
    sessionStorage.setItem('skipPreviousSets', 'false');
  }
        // Загрузим полные данные об упражнении (если нужно)
        const fullExData = await loadFullExerciseData({ id: exObj.id, name: exObj.name });
        addSetToExercise(setsList, exerciseItem, fullExData);
  
        // Обновляем опыт и состояние
        await recalcAndUpdateXP();
        saveWorkoutState();
      });
  
      // Восстанавливаем события для остальных элементов
      notesTextarea.addEventListener('focus', () => {
        notesTextarea.classList.remove('default-value');
      });
      notesTextarea.addEventListener('input', () => {
        notesTextarea.classList.remove('default-value');
      });
  
      exerciseSettingsButton.addEventListener('click', () => {
        openExerciseSettings(exerciseItem, setsList);
      });
  
      exerciseImage.addEventListener('click', () => {
        window.location.href = `exercise?id=${exerciseId}`;
      });
  
      // Восстанавливаем события для уже существующих сетов
      const setItems = setsList.querySelectorAll('.set-item');
      setItems.forEach(setItem => {
        restoreSetEventListeners(setItem, exerciseId);
      });
    });
  }
  

  /**
   * Загрузка полной информации об упражнении (если не хватает данных)
   */
  async function loadFullExerciseData(exercise) {
    // Проверим, есть ли minWeightMale
    if (typeof exercise.minWeightMale === 'number' && typeof exercise.maxWeightMale === 'number') {
      return exercise;
    }
    const exId = exercise.id;
    if (!exId) return exercise; // Без ID не можем ничего загрузить
    try {
      const response = await fetch(`/exerciseInfo?id=${exId}`, {
        credentials: 'include'
      });
      if (!response.ok) {
        console.error('Failed to load full exercise data for', exId);
        return exercise;
      }
      const fullData = await response.json();
      // Если вернулся _id — копируем в .id
      if (!fullData.id && fullData._id) {
        fullData.id = fullData._id;
      }
      return { ...exercise, ...fullData };
    } catch (err) {
      console.error('Ошибка при загрузке данных упражнения:', err);
      return exercise;
    }
  }

  /**
   * Добавляем упражнение (выбранное вручную)
   */
  async function addExerciseToWorkout(exercise) {
    // Загрузим недостающие поля
    exercise = await loadFullExerciseData(exercise);

    // Гарантируем, что use exercise.id
    if (!exercise.id && exercise._id) {
      exercise.id = exercise._id;
    }
    if (!exercise.id) {
      console.error('Нет корректного ID для упражнения:', exercise);
      return;
    }

    const minW = Math.round(calculateMinWeight(exercise));
    const maxW = Math.round(calculateMaxWeight(exercise));

    // Создаём DOM-блок (пример — как у вас)
    const exerciseItem = document.createElement('div');
    exerciseItem.className = 'exercise-item';
    exerciseItem.dataset.exerciseId   = exercise.id;
    exerciseItem.dataset.exerciseName = exercise.name;

    exerciseItem.innerHTML = `
      <div class="exercise-header">
        <img class="exercise-image" src="${exercise.thumbnailUrl || '/default-thumbnail.png'}" alt="${exercise.name}">
        <div class="exercise-details">
          <div class="exercise-name">${exercise.name}</div>
          <div class="exercise-info">
            <div class="info-item">
              <span>1</span>
              <img src="images/icons/xp_sphere.png" alt="XP">
              <span>- ${minW} КГ</span>
            </div>
            <div class="info-separator">|</div>
            <div class="info-item">
              <span>10</span>
              <img src="images/icons/xp_sphere.png" alt="XP">
              <span>- ${maxW} КГ</span>
            </div>
          </div>
        </div>
        <button class="exercise-settings-button">
          <img src="images/icons/gear.png" alt="Настройки">
        </button>
      </div>
      <hr class="small-separator">
      <textarea class="exercise-notes" placeholder="ДОБАВЬТЕ ЗАМЕТКИ ЗДЕСЬ..."></textarea>
      <hr class="small-separator">
      <div class="sets-header">
        <div class="header-item">ПОДХ.</div>
        <div class="header-item">ПРЕД.</div>
        <div class="header-item">КГ.</div>
        <div class="header-item">ПОВТ.</div>
        <div class="header-item">RPE</div>
        <div class="header-item"></div>
      </div>
      <div class="sets-list"></div>
      <button class="add-set-button">+ ДОБАВЬТЕ СЕТ</button>
    `;

    exercisesDiv.appendChild(exerciseItem);

    
    const notesTextarea = exerciseItem.querySelector('.exercise-notes');
    const setsList      = exerciseItem.querySelector('.sets-list');
    const addSetBtn     = exerciseItem.querySelector('.add-set-button');
    const settingsBtn   = exerciseItem.querySelector('.exercise-settings-button');
    const exerciseImage = exerciseItem.querySelector('.exercise-image');

    notesTextarea.addEventListener('focus', () => {
      notesTextarea.classList.remove('default-value');
    });
    notesTextarea.addEventListener('input', () => {
      notesTextarea.classList.remove('default-value');
    });

    addSetBtn.addEventListener('click', () => {
      addSetToExercise(setsList, exerciseItem, exercise);
      recalcAndUpdateXP(); // Обновляем общий опыт и сеты
  });
  

    settingsBtn.addEventListener('click', () => {
      openExerciseSettings(exerciseItem, setsList);
    });

    // Клик по картинке — переход на страницу упражнения
    exerciseImage.addEventListener('click', () => {
      window.location.href = `exercise?id=${exercise.id}`;
    });

    // Добавляем хотя бы один сет
    addSetToExercise(setsList, exerciseItem, exercise);

    // Добавляем в общий массив
    workoutExercises.push({
      id: exercise.id,
      name: exercise.name,
      minWeightMale: exercise.minWeightMale,  // Сохраняем дополнительные данные
      maxWeightMale: exercise.maxWeightMale,
      minWeightFemale: exercise.minWeightFemale,
      maxWeightFemale: exercise.maxWeightFemale,
      sets: [],
      notes: ''
  });
  

    workoutExercises[workoutExercises.length - 1].minWeightMale = exercise.minWeightMale;
workoutExercises[workoutExercises.length - 1].maxWeightMale = exercise.maxWeightMale;
workoutExercises[workoutExercises.length - 1].minWeightFemale = exercise.minWeightFemale;
workoutExercises[workoutExercises.length - 1].maxWeightFemale = exercise.maxWeightFemale;


    saveWorkoutState();
  }

  /**
   * Добавляем упражнение из программы (с уже известным кол-вом сетов и повторов)
   */
  async function addExerciseToWorkoutFromProgram(exercise, setsCount, repsCount) {
    exercise = await loadFullExerciseData(exercise);
    if (!exercise.id && exercise._id) {
      exercise.id = exercise._id;
    }
    if (!exercise.id) {
      console.error('Нет корректного ID для упражнения:', exercise);
      return;
    }

    const minW = Math.round(calculateMinWeight(exercise));
    const maxW = Math.round(calculateMaxWeight(exercise));

    const exerciseItem = document.createElement('div');
    exerciseItem.className = 'exercise-item';
    exerciseItem.dataset.exerciseId   = exercise.id;
    exerciseItem.dataset.exerciseName = exercise.name;

    exerciseItem.innerHTML = `
      <div class="exercise-header">
        <img class="exercise-image" src="${exercise.thumbnailUrl || '/default-thumbnail.png'}" alt="${exercise.name}">
        <div class="exercise-details">
          <div class="exercise-name">${exercise.name}</div>
          <div class="exercise-info">
            <div class="info-item">
              <span>1</span>
              <img src="images/icons/xp_sphere.png" alt="XP">
              <span>- ${minW} КГ</span>
            </div>
            <div class="info-separator">|</div>
            <div class="info-item">
              <span>10</span>
              <img src="images/icons/xp_sphere.png" alt="XP">
              <span>- ${maxW} КГ</span>
            </div>
          </div>
        </div>
        <button class="exercise-settings-button">
          <img src="images/icons/gear.png" alt="Настройки">
        </button>
      </div>
      <hr class="small-separator">
      <textarea class="exercise-notes" placeholder="ДОБАВЬТЕ ЗАМЕТКИ ЗДЕСЬ..."></textarea>
      <hr class="small-separator">
      <div class="sets-header">
        <div class="header-item">ПОДХ.</div>
        <div class="header-item">ПРЕД.</div>
        <div class="header-item">КГ.</div>
        <div class="header-item">ПОВТ.</div>
        <div class="header-item">RPE</div>
        <div class="header-item"></div>
      </div>
      <div class="sets-list"></div>
      <button class="add-set-button">+ ДОБАВЬТЕ СЕТ</button>
    `;

    exercisesDiv.appendChild(exerciseItem);

    const notesTextarea = exerciseItem.querySelector('.exercise-notes');
    const setsList      = exerciseItem.querySelector('.sets-list');
    const addSetBtn     = exerciseItem.querySelector('.add-set-button');
    const settingsBtn   = exerciseItem.querySelector('.exercise-settings-button');
    const exerciseImage = exerciseItem.querySelector('.exercise-image');

    notesTextarea.addEventListener('focus', () => {
      notesTextarea.classList.remove('default-value');
    });
    notesTextarea.addEventListener('input', () => {
      notesTextarea.classList.remove('default-value');
    });

    addSetBtn.addEventListener('click', () => {
      addSetToExercise(setsList, exerciseItem, exercise);
    });

    // Добавляем нужное кол-во сетов
    addSetToExercise(setsList, exerciseItem, exercise);
    for (let i = 1; i < setsCount; i++) {
      addSetToExercise(setsList, exerciseItem, exercise);
    }

    // Ставим repsCount по умолчанию
    const allSetItems = setsList.querySelectorAll('.set-item');
    allSetItems.forEach(setItem => {
      const inputWeight = setItem.querySelector('.input-weight');
      const inputReps   = setItem.querySelector('.input-reps');
      const inputRpe    = setItem.querySelector('.input-rpe');

      inputReps.value = repsCount;
      inputRpe.value  = 5;
      inputWeight.value = minW;
    });

    settingsBtn.addEventListener('click', () => {
      openExerciseSettings(exerciseItem, setsList);
    });

    exerciseImage.addEventListener('click', () => {
      window.location.href = `exercise?id=${exercise.id}`;
    });

    workoutExercises.push({
      id: exercise.id,
      name: exercise.name,
      sets: [],
      notes: ''
    });

    saveWorkoutState();
  }

  /**
   * Добавляем один сет
   */
  function addSetToExercise(setsList, exerciseItem, exercise) {
    const setNumber = setsList.children.length + 1;
    const setItem   = document.createElement('div');
    setItem.className = 'set-item';
    setItem.innerHTML = `
      <div class="set-number">${setNumber}</div>
      <div class="set-data">
        <span class="previous-set">Загрузка...</span>
      </div>
      <input type="number" class="input-weight" placeholder="КГ">
      <input type="number" class="input-reps" placeholder="ПОВТ.">
      <input type="number" class="input-rpe" placeholder="RPE">
      <div class="set-action">
        <button class="check-button"></button>
      </div>
    `;
    setsList.appendChild(setItem);
    
    console.log('Добавлен новый сет:', setItem);
    const checkButton  = setItem.querySelector('.check-button');
    const inputWeight  = setItem.querySelector('.input-weight');
    const inputReps    = setItem.querySelector('.input-reps');
    const inputRpe     = setItem.querySelector('.input-rpe');
    const previousSet  = setItem.querySelector('.previous-set');

    // Подгружаем предыдущие данные (если есть)
    console.log(`Добавление сета: exerciseId=${exerciseItem.dataset.exerciseId}, setNumber=${setNumber}`);

    console.log(`Добавлен новый DOM-элемент сета:`, setItem);

    loadPreviousSetData(exerciseItem.dataset.exerciseId, setNumber, previousSet, inputWeight, inputReps, inputRpe);

    [inputWeight, inputReps, inputRpe].forEach(inp => {
      inp.addEventListener('input', () => {
        inp.classList.remove('default-value');
      });
    });

    checkButton.addEventListener('click', () => {
      
      let wVal   = parseFloat(inputWeight.value);
      let repsVal= parseInt(inputReps.value);
      let rpeVal = parseInt(inputRpe.value);

      if (isNaN(wVal))   wVal = 0;
      if (isNaN(repsVal))repsVal = 0;
      if (isNaN(rpeVal)) rpeVal = 5;

      if (rpeVal < 5 || rpeVal > 10) {
        alert('RPE должно быть от 5 до 10.');
        return;
      }

      // «Закрываем» сет, либо снимаем «completed»
      if (setItem.classList.contains('completed')) {
        setItem.classList.remove('completed');
        checkButton.textContent = '';
        inputWeight.disabled = false;
        inputReps.disabled   = false;
        inputRpe.disabled    = false;
      } else {
        // Отмечаем как completed
        if (!wVal || !repsVal || !rpeVal) {
          alert('Пожалуйста, заполните все поля перед завершением сета.');
          return;
        }
        setItem.classList.add('completed');
        checkButton.textContent = '✔';
        inputWeight.disabled = true;
        inputReps.disabled   = true;
        inputRpe.disabled    = true;
      }
// Восстанавливаем события для нового сета
restoreSetEventListeners(setItem, exerciseItem.dataset.exerciseId);

      recalcAndUpdateXP();
      saveWorkoutState();
      console.log(`Обновляем XP: totalXP=${totalXP}, totalSets=${totalSetsCompleted}`);
      console.log(`Обновление DOM: xpValue=${xpValue.textContent}, setsValue=${setsValue.textContent}`);

    });
  }

  /**
   * Восстанавливаем события для уже имеющегося сета
   */
  function restoreSetEventListeners(setItem, exerciseId) {
    const checkButton = setItem.querySelector('.check-button');
    console.log(`Восстановление событий для сета: exerciseId=${exerciseId}`);
  
    const inputWeight = setItem.querySelector('.input-weight');
    const inputReps = setItem.querySelector('.input-reps');
    const inputRpe = setItem.querySelector('.input-rpe');
  
    // Удаляем старые обработчики перед добавлением новых
    checkButton.replaceWith(checkButton.cloneNode(true));
    const newCheckButton = setItem.querySelector('.check-button');
  
    [inputWeight, inputReps, inputRpe].forEach((inp) => {
      inp.replaceWith(inp.cloneNode(true)); // Удаляем старые обработчики
      const newInput = setItem.querySelector(`.${inp.className.split(' ').join('.')}`);
      newInput.addEventListener('input', () => {
        newInput.classList.remove('default-value');
      });
    });
  
    // Добавляем новый обработчик для checkButton
    newCheckButton.addEventListener('click', () => {
      let wVal = parseFloat(inputWeight.value);
      let repsVal = parseInt(inputReps.value);
      let rpeVal = parseInt(inputRpe.value);
  
      if (isNaN(wVal)) wVal = 0;
      if (isNaN(repsVal)) repsVal = 0;
      if (isNaN(rpeVal)) rpeVal = 5;
  
      if (rpeVal < 5 || rpeVal > 10) {
        alert('RPE должно быть от 5 до 10.');
        return;
      }
  
      if (setItem.classList.contains('completed')) {
        setItem.classList.remove('completed');
        newCheckButton.textContent = '';
        inputWeight.disabled = false;
        inputReps.disabled = false;
        inputRpe.disabled = false;
      } else {
        if (!wVal || !repsVal || !rpeVal) {
          alert('Пожалуйста, заполните все поля перед завершением сета.');
          return;
        }
        setItem.classList.add('completed');
        newCheckButton.textContent = '✔';
        inputWeight.disabled = true;
        inputReps.disabled = true;
        inputRpe.disabled = true;
      }
  
      recalcAndUpdateXP();
      saveWorkoutState();
    });
  }
  

  /**
   * Загрузка предыдущего сета (если есть)
   */
  async function loadPreviousSetData(exerciseId, setNumber, previousSetElement, inputWeight, inputReps, inputRpe) {
    
    if (isProgramStart) {
        previousSetElement.textContent = 'Нет данных';
        return;
    }
    try {
        if (!exerciseId || exerciseId === 'undefined') {
            previousSetElement.textContent = 'Нет данных';
            return;
        }

        // Запрос к серверу для получения только последней тренировки
        console.log(`Запрос к /lastExerciseSets: exerciseId=${exerciseId}, setNumber=${setNumber}`);
        const response = await fetch(`/lastExerciseSets?exerciseId=${exerciseId}`, {
            credentials: 'include'
        });

        if (!response.ok) {
            console.error(`Ошибка при запросе к /lastExerciseSets: ${response.status}`);
            previousSetElement.textContent = 'Нет данных';
            return;
        }

        const data = await response.json();
        console.log('Ответ от /lastExerciseSets:', data);

        if (data.sets && data.sets.length >= setNumber) {
            // Берём конкретный сет (по номеру)
            const previousSet = data.sets[setNumber - 1];
            let { weight, reps, rpe } = previousSet;
            weight = Math.round(weight);
            previousSetElement.textContent = `${weight}кг x ${reps} повторений @ RPE ${rpe}`;
            
            // Заполняем поля по умолчанию
            inputWeight.value = weight;
            inputReps.value = reps;
            inputRpe.value = rpe;
        } else {
            // Если подход не найден
            previousSetElement.textContent = 'Нет данных';
        }
    } catch (error) {
        console.error('Ошибка при загрузке предыдущих данных сета:', error);
        previousSetElement.textContent = 'Нет данных';
    }
}


  /**
   * Окно настроек упражнения (иконка «gear»)
   */
  function openExerciseSettings(exerciseItem, setsList) {
    const exerciseSettingsModal = document.createElement('div');
    exerciseSettingsModal.classList.add('modal');
    exerciseSettingsModal.innerHTML = `
      <div class="modal-content">
        <div class="modal-title">НАСТРОЙКИ</div>
        <hr class="small-separator">
        <button id="deleteExerciseButton" class="secondary-button delete-exercise-button">УДАЛИТЬ УПРАЖНЕНИЕ</button>
        <hr class="very-small-separator">
        <button id="deleteSetButton" class="secondary-button delete-exercise-button">УДАЛИТЬ СЕТ</button>
      </div>
    `;
    document.body.appendChild(exerciseSettingsModal);
    exerciseSettingsModal.style.display = 'block';

    const deleteExerciseButton = exerciseSettingsModal.querySelector('#deleteExerciseButton');
    const deleteSetButton      = exerciseSettingsModal.querySelector('#deleteSetButton');

    exerciseSettingsModal.addEventListener('click', (event) => {
      if (event.target === exerciseSettingsModal) {
        exerciseSettingsModal.style.display = 'none';
        document.body.removeChild(exerciseSettingsModal);
      }
    });

    deleteExerciseButton.addEventListener('click', () => {
      exerciseSettingsModal.style.display = 'none';
      document.body.removeChild(exerciseSettingsModal);
      openConfirmationModal(
        'Вы точно хотите удалить упражнение?',
        () => {
          exercisesDiv.removeChild(exerciseItem);
          workoutExercises = workoutExercises.filter(ex => ex.id !== exerciseItem.dataset.exerciseId);
          recalcAndUpdateXP();
          saveWorkoutState();
        },
        () => {}
      );
    });

    deleteSetButton.addEventListener('click', () => {
      if (setsList.children.length === 0) {
          alert('Нет сетов для удаления.');
          return;
      }
      const lastSetItem = setsList.lastElementChild;
      setsList.removeChild(lastSetItem);
      recalcAndUpdateXP(); // Обновляем после удаления
      saveWorkoutState();
  });
  
  }

  /**
   * Модальное окно подтверждения (да/нет)
   */
  function openConfirmationModal(message, onConfirm, onCancel) {
    const confirmationModal = document.createElement('div');
    confirmationModal.classList.add('modal');

    const modalContent = document.createElement('div');
    modalContent.classList.add('modal-content');

    const modalMessage = document.createElement('p');
    modalMessage.textContent = message;

    const buttonsContainer = document.createElement('div');
    buttonsContainer.classList.add('modal-buttons');

    const confirmButton = document.createElement('button');
    confirmButton.textContent = 'Да';
    confirmButton.classList.add('confirm-button');

    const cancelButton = document.createElement('button');
    cancelButton.textContent = 'Отмена';
    cancelButton.classList.add('cancel-button');

    buttonsContainer.appendChild(confirmButton);
    buttonsContainer.appendChild(cancelButton);

    modalContent.appendChild(modalMessage);
    modalContent.appendChild(buttonsContainer);

    confirmationModal.appendChild(modalContent);
    document.body.appendChild(confirmationModal);
    confirmationModal.style.display = 'block';

    confirmButton.addEventListener('click', () => {
      onConfirm();
      closeModal();
    });

    cancelButton.addEventListener('click', () => {
      if (onCancel) onCancel();
      closeModal();
    });

    confirmationModal.addEventListener('click', (event) => {
      if (event.target === confirmationModal) {
        if (onCancel) onCancel();
        closeModal();
      }
    });

    function closeModal() {
      confirmationModal.style.display = 'none';
      document.body.removeChild(confirmationModal);
    }
  }

  /**
   * Функции расчёта корректировок веса и XP
   */
  
  function calculateMinWeight(exercise) {
    const userGender = userData.gender || 'male';
    let baseMin = (userGender === 'female') ? exercise.minWeightFemale : exercise.minWeightMale;
    if (typeof baseMin !== 'number') baseMin = 0;
    console.log(`calculateMinWeight: exercise=${JSON.stringify(exercise)}, baseMin=${baseMin}`);
    let avgWeight = (userGender === 'female') ? 60 : 70;
    let userW = userData.weight || avgWeight;
    const factor = userW / avgWeight;
    const result = baseMin * factor;
    console.log(`calculateMinWeight: baseMin=${baseMin}, userW=${userW}, factor=${factor}, result=${result}`);
    return result;
}


function calculateMaxWeight(exercise) {
  const userGender = userData.gender || 'male';
  let baseMax = (userGender === 'female') ? exercise.maxWeightFemale : exercise.maxWeightMale;
  if (typeof baseMax !== 'number') baseMax = 0;
  console.log(`calculateMaxWeight: exercise=${JSON.stringify(exercise)}, baseMax=${baseMax}`);
  let avgWeight = (userGender === 'female') ? 60 : 70;
  let userW = userData.weight || avgWeight;
  const factor = userW / avgWeight;
  const result = baseMax * factor;
  console.log(`calculateMaxWeight: baseMax=${baseMax}, userW=${userW}, factor=${factor}, result=${result}`);
  return result;
}



function calculateWeightLevel(weight, exercise) {
  const minWeight = Math.round(calculateMinWeight(exercise));
  const maxWeight = Math.round(calculateMaxWeight(exercise));

  if (weight <= minWeight) {
      console.log(`Вес меньше или равен минимальному: weight=${weight}, minWeight=${minWeight}, level=1`);
      return 1;
  }
  if (weight >= maxWeight) {
      console.log(`Вес больше или равен максимальному: weight=${weight}, maxWeight=${maxWeight}, level=10`);
      return 10;
  }

  const ratio = (weight - minWeight) / (maxWeight - minWeight);
  const level = Math.round(ratio * 9 + 1);
  console.log(`Вес в диапазоне: weight=${weight}, minWeight=${minWeight}, maxWeight=${maxWeight}, level=${level}`);
  return level;
}



  /**
   * Формула XP = ( (weightXP * reps) + RPEBonus ) * multiRepFactor
   */
  function calculateXP(weight, reps, rpe, exercise) {
    weight = parseFloat(weight);
    reps   = parseInt(reps);
    rpe    = parseInt(rpe);
    if (isNaN(weight) || isNaN(reps) || isNaN(rpe) || reps <= 0) {
      return 0;
    }
    const weightXP = calculateWeightLevel(weight, exercise);
    const baseXP   = weightXP * reps;

    let rpeBonus = 0;
    if (rpe > 5) {
      const percent = (rpe - 5) * 0.05;
      rpeBonus = baseXP * percent;
    }

    let multiRepFactor = 1.0;
    if (reps >= 13 && reps <= 15) {
      multiRepFactor = 0.8;
    } else if (reps >= 16) {
      multiRepFactor = 0.5;
    }

    const setXP = Math.round((baseXP + rpeBonus) * multiRepFactor);

    // Логирование после расчёта опыта
    console.log(`Рассчитанный опыт: weight=${weight}, reps=${reps}, rpe=${rpe}, xp=${setXP}`);

    return setXP;
}

  /**
   * Подсчитываем общее XP и завершённые сеты
   */
  async function recalculateTotalXPFromWorkoutExercises() {
    let newTotalXP = 0;
    let newTotalSets = 0;

    for (let i = 0; i < workoutExercises.length; i++) {
        const ex = workoutExercises[i];

        // Проверяем, есть ли данные о весах
        if (!ex.minWeightMale || !ex.maxWeightMale) {
            console.log(`recalculateTotalXP: Недостаточно данных, загружаем информацию об упражнении id=${ex.id}`);
            const fullExData = await loadFullExerciseData(ex); // Загружаем недостающие данные
            Object.assign(ex, fullExData); // Обновляем объект упражнения
        }

        ex.sets.forEach(st => {
            if (st.completed) {
                console.log(`recalculateTotalXP: Передача упражнения в calculateXP: ${JSON.stringify(ex)}`);
                const xpGained = calculateXP(st.weight, st.reps, st.rpe, ex);
                newTotalXP += xpGained;
                newTotalSets++;
            }
        });
    }

    return { newTotalXP, newTotalSets };
}



  /**
   * Пересчитываем и обновляем на экране
   */
  async function recalcAndUpdateXP() {
    updateWorkoutExercisesFromDOM();
    const { newTotalXP, newTotalSets } = await recalculateTotalXPFromWorkoutExercises();

    // Обновляем глобальные переменные
    totalXP = newTotalXP;
    totalSetsCompleted = newTotalSets;

    // Обновляем DOM
    xpValue.textContent = `${Math.round(totalXP)} XP`;
    setsValue.textContent = totalSetsCompleted;

    console.log(`Обновлено общее XP=${totalXP}, завершенные сеты=${totalSetsCompleted}`);
}


  /**
   * Сохраняем тренировку на бэкенде
   */
  function saveWorkout() {
    updateWorkoutExercisesFromDOM();
    const { newTotalXP, newTotalSets } = recalculateTotalXPFromWorkoutExercises();
    totalXP            = newTotalXP;
    totalSetsCompleted = newTotalSets;
    console.log(`Обновлено: общее XP=${totalXP}, завершённые сеты=${totalSetsCompleted}`);

    xpValue.textContent   = `${Math.round(totalXP)} XP`;
    setsValue.textContent = totalSetsCompleted;

    const totalWorkoutTime = timeValue.textContent || '';

    // Формируем объект для отправки
    const workoutData = {
      exercises: [],
      totalWorkoutTime
    };
// --- СНАЧАЛА проверяем, есть ли currentProgram, и добавляем programId ---
const currentProgram = sessionStorage.getItem('currentProgramWorkout');
if (currentProgram) {
  const parsed = JSON.parse(currentProgram);
  workoutData.programId = parsed.id;
}
    for (const ex of workoutExercises) {
      if (!ex.id || ex.id === 'undefined') {
        console.error('Некорректный ID упражнения:', ex);
        alert('Ошибка: Есть упражнение с некорректным ID. Удалите и добавьте заново.');
        return;
      }
      workoutData.exercises.push({
        exerciseId: ex.id,
        sets: ex.sets,
        notes: ex.notes || ''
      });
    }

    console.log('Данные для отправки:', workoutData);

    // Проверка наличия meta[name="csrf-token"]
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    if (!csrfMeta) {
      console.error('CSRF токен отсутствует!');
      alert('Ошибка: CSRF токен не найден. Попробуйте обновить страницу.');
      return;
    }
    const csrfToken = csrfMeta.getAttribute('content');
    console.log('Извлечён CSRF токен:', csrfToken);

    fetch('/addWorkout', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
      },
      // ВАЖНО: чтобы Laravel сессия передавалась, указываем credentials
      credentials: 'include',
      body: JSON.stringify(workoutData)
    })
      .then(response => {
        console.log('Статус ответа:', response.status);
        if (!response.ok) {
          throw new Error(`Ошибка сети: ${response.statusText}`);
        }
        return response.json();
      })
      .then(data => {
        console.log('Ответ сервера:', data);
        alert(`Тренировка сохранена! Вы заработали ${data.xpGained} опыта.`);
        sessionStorage.removeItem('workoutState');
        // Переходим, например, в профиль
        window.location.href = 'profile';
      })
      .catch(error => {
        console.error('Ошибка при сохранении тренировки:', error);
        alert('Произошла ошибка при сохранении тренировки.');
      });


  // Счётчик локального хранилища
  const key = `programCompletions_${parsedProgram.id}`;
  let val = localStorage.getItem(key);
  let completions = val ? parseInt(val) : 0;
  completions++;
  localStorage.setItem(key, completions.toString());

  // Чистим sessionStorage
  sessionStorage.removeItem('currentProgramWorkout');
}

  }
  
);
