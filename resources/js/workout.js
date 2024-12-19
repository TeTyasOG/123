document.addEventListener('DOMContentLoaded', async () => {
  const backButton = document.getElementById('backButton');
  const finishButton = document.getElementById('finishButton');
  const addExerciseButton = document.getElementById('addExerciseButton');
  const deleteWorkoutButton = document.getElementById('deleteWorkoutButton');
  const exercisesDiv = document.getElementById('exercises');

  const timeValue = document.getElementById('timeValue');
  const xpValue = document.getElementById('xpValue');
  const setsValue = document.getElementById('setsValue');

  let workoutStartTime = new Date();
  let workoutInterval;
  let totalXP = 0;
  let totalSetsCompleted = 0;
  let workoutExercises = [];
  let userData = {};

  let isProgramStart = false;

  sessionStorage.setItem('returnTo', 'workout');

  await loadUserData();
  await loadWorkoutState();

  backButton.addEventListener('click', () => {
    window.location.href = 'training.html';
  });

  finishButton.addEventListener('click', () => {
    if (hasIncompleteSets()) {
      alert('Есть невыполненные сеты. Завершите или удалите их прежде чем закончить тренировку.');
      return;
    }

    openConfirmationModal(
      'Вы точно хотите завершить тренировку?',
      () => {
        clearInterval(workoutInterval);
        saveWorkout();
      },
      () => {}
    );
  });

  addExerciseButton.addEventListener('click', () => {
    saveWorkoutState();
    window.location.href = 'addExercise.html';
  });

  deleteWorkoutButton.addEventListener('click', () => {
    openConfirmationModal(
      'Вы точно хотите удалить тренировку?',
      () => {
        sessionStorage.clear();
        window.location.href = 'training.html';
      },
      () => {}
    );
  });

  const selectedExerciseJSON = sessionStorage.getItem('selectedExercise');
  if (selectedExerciseJSON) {
    const selectedExercise = JSON.parse(selectedExerciseJSON);
    await addExerciseToWorkout(selectedExercise, false);
    sessionStorage.removeItem('selectedExercise');
    saveWorkoutState();
  }

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

  async function loadUserData() {
    try {
      const response = await fetch('/getUserProfile');
      if (!response.ok) {
        throw new Error('Ошибка при загрузке профиля пользователя');
      }
      userData = await response.json();
    } catch (error) {
      console.error('Ошибка при загрузке данных пользователя:', error);
    }
  }

  async function loadFullExerciseData(exercise) {
    if (typeof exercise.minWeightMale === 'number' && typeof exercise.maxWeightMale === 'number') {
      return exercise;
    }
    const response = await fetch(`/exerciseInfo?id=${exercise._id}`);
    if (!response.ok) {
      console.error('Failed to load full exercise data for', exercise._id);
      return exercise;
    }
    const fullData = await response.json();
    return { ...exercise, ...fullData };
  }

  function saveWorkoutState() {
    const workoutState = {
      workoutStartTime: workoutStartTime.toISOString(),
      totalXP,
      totalSetsCompleted,
      workoutExercises,
      exercisesHTML: exercisesDiv.innerHTML
    };
    sessionStorage.setItem('workoutState', JSON.stringify(workoutState));
  }

  async function loadWorkoutState() {
    const workoutStateJSON = sessionStorage.getItem('workoutState');
    if (workoutStateJSON) {
      const workoutState = JSON.parse(workoutStateJSON);
      workoutStartTime = new Date(workoutState.workoutStartTime);
      totalXP = workoutState.totalXP || 0;
      totalSetsCompleted = workoutState.totalSetsCompleted || 0;
      workoutExercises = workoutState.workoutExercises || [];
      exercisesDiv.innerHTML = workoutState.exercisesHTML || '';
      xpValue.textContent = `${Math.round(totalXP)} XP`;
      setsValue.textContent = totalSetsCompleted;
      restoreExerciseEventListeners();
      startWorkoutTimer();
    } else {
      workoutStartTime = new Date();
      totalXP = 0;
      totalSetsCompleted = 0;
      workoutExercises = [];
      exercisesDiv.innerHTML = '';
      xpValue.textContent = '0 XP';
      setsValue.textContent = '0';

      const currentProgram = sessionStorage.getItem('currentProgramWorkout');
      if (currentProgram) {
        const programData = JSON.parse(currentProgram);
        isProgramStart = true;
        for (const pEx of programData.exercises) {
          const exerciseId = pEx.exerciseId;
          const setsCount = pEx.sets;
          const repsCount = pEx.reps;
          const exerciseResponse = await fetch(`/exerciseInfo?id=${exerciseId}`);
          if (exerciseResponse.ok) {
            const exData = await exerciseResponse.json();
            exData._id = exerciseId;
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

  function startWorkoutTimer() {
    if (workoutInterval) clearInterval(workoutInterval);
    workoutInterval = setInterval(() => {
      const now = new Date();
      const elapsed = new Date(now - workoutStartTime);
      const hours = elapsed.getUTCHours();
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

  function calculateMinWeight(exercise, userData) {
    const userGender = userData.gender || 'male';
    let baseWeight, avgWeight;
    if (userGender === 'male') {
      baseWeight = exercise.minWeightMale;
      avgWeight = 70;
    } else {
      baseWeight = exercise.minWeightFemale;
      avgWeight = 60;
    }
    const userWeight = userData.weight || avgWeight;
    const weightAdjustmentFactor = userWeight / avgWeight;
    return baseWeight * weightAdjustmentFactor;
  }

  function calculateMaxWeight(exercise, userData) {
    const userGender = userData.gender || 'male';
    let baseWeight, avgWeight;
    if (userGender === 'male') {
      baseWeight = exercise.maxWeightMale;
      avgWeight = 70;
    } else {
      baseWeight = exercise.maxWeightFemale;
      avgWeight = 60;
    }
    const userWeight = userData.weight || avgWeight;
    const weightAdjustmentFactor = userWeight / avgWeight;

    return baseWeight * weightAdjustmentFactor;
  }

  function calculateWeightLevel(weight, exercise) {
    weight = parseFloat(weight);
    if (isNaN(weight)) return 1;
    const minW = calculateMinWeight(exercise, userData);
    const maxW = calculateMaxWeight(exercise, userData);
    const weightRange = maxW - minW;
    if (weightRange <= 0) return 1;
    let level = ((weight - minW) / weightRange) * 9 + 1;
    level = Math.max(1, Math.min(10, level));
    return Math.round(level);
  }

  function calculateXP(weight, reps, rpe, exercise) {
    weight = parseFloat(weight);
    reps = parseInt(reps);
    rpe = parseInt(rpe);
    if (isNaN(weight) || isNaN(reps) || isNaN(rpe)) {
      return 0;
    }
    const weightLevel = calculateWeightLevel(weight, exercise);
    const rpeBonus = (rpe - 5) * 0.05;
    const xp = weightLevel * reps * (1 + rpeBonus);
    return Math.round(xp);
  }

  async function loadPreviousNotes(exerciseId, notesTextarea) {
    if (isProgramStart) {
      return;
    }

    try {
      const response = await fetch(`/getExerciseNotes?exerciseId=${exerciseId}`);
      const data = await response.json();

      if (data.notes) {
        notesTextarea.value = data.notes;
        notesTextarea.classList.remove('default-value');
      } else {
        notesTextarea.placeholder = 'ДОБАВЬТЕ ЗАМЕТКИ ЗДЕСЬ...';
      }
    } catch (error) {
      console.error('Ошибка при загрузке предыдущих заметок:', error);
    }
  }

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
      const response = await fetch(`/exerciseHistory?exerciseId=${exerciseId}&setNumber=${setNumber}`);
      const data = await response.json();

      if (data.previousSet) {
        let { weight, reps, rpe } = data.previousSet;
        weight = Math.round(weight);
        previousSetElement.textContent = `${weight}кг x ${reps} повторений @ RPE ${rpe}`;
        inputWeight.value = weight;
        inputReps.value = reps;
        inputRpe.value = rpe;
      } else {
        previousSetElement.textContent = 'Нет данных';
      }
    } catch (error) {
      console.error('Ошибка при загрузке предыдущих данных сета:', error);
      previousSetElement.textContent = 'Нет данных';
    }
  }

  function updateWorkoutExercisesFromDOM() {
    const newWorkoutExercises = [];
    const exerciseItems = exercisesDiv.querySelectorAll('.exercise-item');
    exerciseItems.forEach(exerciseItem => {
      const exId = exerciseItem.dataset.exerciseId;
      const exName = exerciseItem.dataset.exerciseName;
      const sets = [];
      const notes = exerciseItem.querySelector('.exercise-notes')?.value || '';
      const setsList = exerciseItem.querySelectorAll('.set-item');
      setsList.forEach(setItem => {
        let w = setItem.querySelector('.input-weight').value;
        let r = setItem.querySelector('.input-reps').value;
        let rr = setItem.querySelector('.input-rpe').value;

        let weightVal = parseFloat(w);
        if (isNaN(weightVal)) weightVal = 0;
        weightVal = Math.round(weightVal);

        let repsVal = parseInt(r);
        if (isNaN(repsVal)) repsVal = 0;

        let rpeVal = parseInt(rr);
        if (isNaN(rpeVal)) rpeVal = 5;

        const completed = setItem.classList.contains('completed');
        sets.push({ weight: weightVal, reps: repsVal, rpe: rpeVal, completed });
      });
      newWorkoutExercises.push({ id: exId, name: exName, sets, notes });
    });
    workoutExercises = newWorkoutExercises;
  }

  function recalcAndUpdateXP() {
    updateWorkoutExercisesFromDOM();
    const { newTotalXP, newTotalSets } = recalculateTotalXPFromWorkoutExercises();
    totalXP = newTotalXP;
    totalSetsCompleted = newTotalSets;
    xpValue.textContent = `${Math.round(totalXP)} XP`;
    setsValue.textContent = totalSetsCompleted;
  }

  function addSetToExercise(setsList, exerciseItem, exercise) {
    const setNumber = setsList.children.length + 1;
    const setItem = document.createElement('div');
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

    const checkButton = setItem.querySelector('.check-button');
    const inputWeight = setItem.querySelector('.input-weight');
    const inputReps = setItem.querySelector('.input-reps');
    const inputRpe = setItem.querySelector('.input-rpe');
    const previousSet = setItem.querySelector('.previous-set');

    loadPreviousSetData(exerciseItem.dataset.exerciseId, setNumber, previousSet, inputWeight, inputReps, inputRpe);

    [inputWeight, inputReps, inputRpe].forEach(input => {
      input.addEventListener('input', () => {
        input.classList.remove('default-value');
      });
    });

    checkButton.addEventListener('click', () => {
      const exObj = exercise;
      let weightVal = parseFloat(inputWeight.value);
      if (isNaN(weightVal)) weightVal = 0;
      weightVal = Math.round(weightVal);

      let repsVal = parseInt(inputReps.value);
      if (isNaN(repsVal)) repsVal = 0;

      let rpeVal = parseInt(inputRpe.value);
      if (isNaN(rpeVal)) rpeVal = 5;

      if (rpeVal < 5 || rpeVal > 10) {
        alert('RPE должно быть от 5 до 10.');
        return;
      }

      if (setItem.classList.contains('completed')) {
        setItem.classList.remove('completed');
        checkButton.textContent = '';
        recalcAndUpdateXP();
        inputWeight.disabled = false;
        inputReps.disabled = false;
        inputRpe.disabled = false;
      } else {
        if (!weightVal || !repsVal || !rpeVal) {
          alert('Пожалуйста, заполните все поля перед завершением сета.');
          return;
        }

        setItem.classList.add('completed');
        checkButton.textContent = '✔';
        inputWeight.disabled = true;
        inputReps.disabled = true;
        inputRpe.disabled = true;
        recalcAndUpdateXP();
      }

      saveWorkoutState();
    });
  }

  async function addExerciseToWorkout(exercise, fromProgram = false) {
    exercise = await loadFullExerciseData(exercise);

    if (!exercise._id && exercise.exerciseId) {
      exercise._id = exercise.exerciseId;
    }

    const minWeight = Math.round(calculateMinWeight(exercise, userData));
    const maxWeight = Math.round(calculateMaxWeight(exercise, userData));

    const exerciseItem = document.createElement('div');
    exerciseItem.className = 'exercise-item';
    exerciseItem.dataset.exerciseId = exercise._id;
    exerciseItem.dataset.exerciseName = exercise.name;

    exerciseItem.innerHTML = `
      <div class="exercise-header">
        <img class="exercise-image" src="${exercise.thumbnailUrl}" alt="${exercise.name}">
        <div class="exercise-details">
          <div class="exercise-name">${exercise.name}</div>
          <div class="exercise-info">
            <div class="info-item">
              <span>1</span>
              <img src="images/icons/xp_sphere.png" alt="XP">
              <span>- ${minWeight} КГ</span>
            </div>
            <div class="info-separator">|</div>
            <div class="info-item">
              <span>10</span>
              <img src="images/icons/xp_sphere.png" alt="XP">
              <span>- ${maxWeight} КГ</span>
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

    const addSetButton = exerciseItem.querySelector('.add-set-button');
    const setsList = exerciseItem.querySelector('.sets-list');
    const exerciseSettingsButton = exerciseItem.querySelector('.exercise-settings-button');
    const exerciseImage = exerciseItem.querySelector('.exercise-image');
    const notesTextarea = exerciseItem.querySelector('.exercise-notes');

    if (!isProgramStart) {
      await loadPreviousNotes(exerciseItem.dataset.exerciseId, notesTextarea);
    }

    notesTextarea.addEventListener('focus', () => {
      notesTextarea.classList.remove('default-value');
    });

    notesTextarea.addEventListener('input', () => {
      notesTextarea.classList.remove('default-value');
    });

    addSetButton.addEventListener('click', () => {
      const exObj = exercise;
      addSetToExercise(setsList, exerciseItem, exObj);
    });

    addSetToExercise(setsList, exerciseItem, exercise);

    exerciseSettingsButton.addEventListener('click', () => {
      openExerciseSettings(exerciseItem, setsList);
    });

    exerciseImage.addEventListener('click', () => {
      window.location.href = `exercise.html?id=${exercise._id}`;
    });

    workoutExercises.push({
      id: exercise._id,
      name: exercise.name,
      sets: [],
      notes: ''
    });

    saveWorkoutState();
  }

  async function addExerciseToWorkoutFromProgram(exercise, setsCount, repsCount) {

    exercise = await loadFullExerciseData(exercise);

    const minWeightVal = Math.round(calculateMinWeight(exercise, userData));
    const maxWeightVal = Math.round(calculateMaxWeight(exercise, userData));

    const exerciseItem = document.createElement('div');
    exerciseItem.className = 'exercise-item';
    exerciseItem.dataset.exerciseId = exercise._id;
    exerciseItem.dataset.exerciseName = exercise.name;

    exerciseItem.innerHTML = `
      <div class="exercise-header">
        <img class="exercise-image" src="${exercise.thumbnailUrl}" alt="${exercise.name}">
        <div class="exercise-details">
          <div class="exercise-name">${exercise.name}</div>
          <div class="exercise-info">
            <div class="info-item">
              <span>1</span>
              <img src="images/icons/xp_sphere.png" alt="XP">
              <span>- ${minWeightVal} КГ</span>
            </div>
            <div class="info-separator">|</div>
            <div class="info-item">
              <span>10</span>
              <img src="images/icons/xp_sphere.png" alt="XP">
              <span>- ${maxWeightVal} КГ</span>
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

    const addSetButton = exerciseItem.querySelector('.add-set-button');
    const setsList = exerciseItem.querySelector('.sets-list');
    const exerciseSettingsButton = exerciseItem.querySelector('.exercise-settings-button');
    const exerciseImage = exerciseItem.querySelector('.exercise-image');
    const notesTextarea = exerciseItem.querySelector('.exercise-notes');

    notesTextarea.addEventListener('focus', () => {
      notesTextarea.classList.remove('default-value');
    });

    notesTextarea.addEventListener('input', () => {
      notesTextarea.classList.remove('default-value');
    });

    addSetButton.addEventListener('click', () => {
      const exObj = exercise;
      addSetToExercise(setsList, exerciseItem, exObj);
    });

    const exObj = exercise;
    addSetToExercise(setsList, exerciseItem, exObj);
    for (let i = 1; i < setsCount; i++) {
      addSetToExercise(setsList, exerciseItem, exObj);
    }

    const allSetItems = setsList.querySelectorAll('.set-item');
    allSetItems.forEach(setItem => {
      const inputWeight = setItem.querySelector('.input-weight');
      const inputReps = setItem.querySelector('.input-reps');
      const inputRpe = setItem.querySelector('.input-rpe');
      inputReps.value = repsCount;
      inputRpe.value = 5;
      inputWeight.value = minWeightVal;
    });

    exerciseSettingsButton.addEventListener('click', () => {
      openExerciseSettings(exerciseItem, setsList);
    });

    exerciseImage.addEventListener('click', () => {
      window.location.href = `exercise.html?id=${exercise._id}`;
    });

    workoutExercises.push({
      id: exercise._id,
      name: exercise.name,
      sets: [],
      notes: ''
    });

    saveWorkoutState();
  }

  function restoreSetEventListeners(setItem, exerciseId) {
    const checkButton = setItem.querySelector('.check-button');
    const inputWeight = setItem.querySelector('.input-weight');
    const inputReps = setItem.querySelector('.input-reps');
    const inputRpe = setItem.querySelector('.input-rpe');

    [inputWeight, inputReps, inputRpe].forEach(input => {
      input.addEventListener('input', () => {
        input.classList.remove('default-value');
      });
    });

    checkButton.addEventListener('click', async () => {
      const exData = workoutExercises.find(ex => ex.id === exerciseId);
      const exercise = { _id: exData.id, minWeightMale: 20, maxWeightMale: 100, ...exData };

      let weightVal = parseFloat(inputWeight.value);
      if (isNaN(weightVal)) weightVal = 0;
      weightVal = Math.round(weightVal);

      let repsVal = parseInt(inputReps.value);
      if (isNaN(repsVal)) repsVal = 0;

      let rpeVal = parseInt(inputRpe.value);
      if (isNaN(rpeVal)) rpeVal = 5;

      if (rpeVal < 5 || rpeVal > 10) {
        alert('RPE должно быть от 5 до 10.');
        return;
      }

      if (setItem.classList.contains('completed')) {
        setItem.classList.remove('completed');
        checkButton.textContent = '';
        recalcAndUpdateXP();
        inputWeight.disabled = false;
        inputReps.disabled = false;
        inputRpe.disabled = false;
      } else {
        if (!weightVal || !repsVal || !rpeVal) {
          alert('Пожалуйста, заполните все поля перед завершением сета.');
          return;
        }
        setItem.classList.add('completed');
        checkButton.textContent = '✔';
        inputWeight.disabled = true;
        inputReps.disabled = true;
        inputRpe.disabled = true;
        recalcAndUpdateXP();
      }

      saveWorkoutState();
    });
  }

  function restoreExerciseEventListeners() {
    const exerciseItems = exercisesDiv.querySelectorAll('.exercise-item');
    exerciseItems.forEach(exerciseItem => {
      const exerciseId = exerciseItem.dataset.exerciseId;
      const exerciseName = exerciseItem.dataset.exerciseName;
      const addSetButton = exerciseItem.querySelector('.add-set-button');
      const setsList = exerciseItem.querySelector('.sets-list');
      const exerciseSettingsButton = exerciseItem.querySelector('.exercise-settings-button');
      const exerciseImage = exerciseItem.querySelector('.exercise-image');
      const notesTextarea = exerciseItem.querySelector('.exercise-notes');

      notesTextarea.addEventListener('focus', () => {
        notesTextarea.classList.remove('default-value');
      });

      notesTextarea.addEventListener('input', () => {
        notesTextarea.classList.remove('default-value');
      });

      addSetButton.addEventListener('click', async () => {
        const exObj = workoutExercises.find(ex => ex.id === exerciseId);
        const fullExData = await loadFullExerciseData({ _id: exObj.id, name: exObj.name });
        addSetToExercise(setsList, exerciseItem, fullExData);
      });

      exerciseSettingsButton.addEventListener('click', () => {
        openExerciseSettings(exerciseItem, setsList);
      });

      exerciseImage.addEventListener('click', () => {
        window.location.href = `exercise.html?id=${exerciseId}`;
      });

      const setItems = setsList.querySelectorAll('.set-item');
      setItems.forEach(setItem => {
        restoreSetEventListeners(setItem, exerciseId);
      });
    });
  }

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
    const deleteSetButton = exerciseSettingsModal.querySelector('#deleteSetButton');

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
      exerciseSettingsModal.style.display = 'none';
      document.body.removeChild(exerciseSettingsModal);
      recalcAndUpdateXP();
      saveWorkoutState();
    });
  }

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

  function recalculateTotalXPFromWorkoutExercises() {
    let newTotalXP = 0;
    let newTotalSets = 0;
    workoutExercises.forEach(ex => {
      ex.sets.forEach(st => {
        if (st.completed) {
          const exerciseObj = { _id: ex.id, minWeightMale: 20, maxWeightMale: 100 };
          const xpGained = calculateXP(st.weight, st.reps, st.rpe, exerciseObj);
          newTotalXP += xpGained;
          newTotalSets++;
        }
      });
    });
    return { newTotalXP, newTotalSets };
  }

  function recalcAndUpdateXP() {
    updateWorkoutExercisesFromDOM();
    const { newTotalXP, newTotalSets } = recalculateTotalXPFromWorkoutExercises();
    totalXP = newTotalXP;
    totalSetsCompleted = newTotalSets;
    xpValue.textContent = `${Math.round(totalXP)} XP`;
    setsValue.textContent = totalSetsCompleted;
  }

  function saveWorkout() {
    updateWorkoutExercisesFromDOM();

    const { newTotalXP, newTotalSets } = recalculateTotalXPFromWorkoutExercises();
    totalXP = newTotalXP;
    totalSetsCompleted = newTotalSets;
    xpValue.textContent = `${Math.round(totalXP)} XP`;
    setsValue.textContent = totalSetsCompleted;

    // Получаем время тренировки из timeValue
    const totalWorkoutTime = timeValue.textContent || '';

    const workoutData = {
      exercises: [],
      totalWorkoutTime: totalWorkoutTime  // Передаем общее время тренировки на сервер
    };

    workoutExercises.forEach(exerciseItem => {
      workoutData.exercises.push({
        exerciseId: exerciseItem.id,
        sets: exerciseItem.sets,
        notes: exerciseItem.notes
      });
    });

    fetch('/addWorkout', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(workoutData)
    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Ошибка сети');
        }
        return response.json();
      })
      .then(data => {
        alert(`Тренировка сохранена! Вы заработали ${data.xpGained} опыта.`);
        sessionStorage.removeItem('workoutState');
        const currentProgram = sessionStorage.getItem('currentProgramWorkout');
        if (currentProgram) {
          const programData = JSON.parse(currentProgram);
          const key = `programCompletions_${programData.id}`;
          let val = localStorage.getItem(key);
          let completions = val ? parseInt(val) : 0;
          completions++;
          localStorage.setItem(key, completions.toString());
          sessionStorage.removeItem('currentProgramWorkout');
        }
        window.location.href = 'profile.html';
      })
      .catch(error => {
        console.error('Ошибка при сохранении тренировки:', error);
        alert('Произошла ошибка при сохранении тренировки.');
      });
  }
});
