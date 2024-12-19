document.addEventListener('DOMContentLoaded', () => {
  const cancelButton = document.getElementById('cancelButton');
  const finishButton = document.getElementById('finishButton');
  const confirmCancel = document.getElementById('confirmCancel');
  const cancelCancel = document.getElementById('cancelCancel');
  const confirmFinish = document.getElementById('confirmFinish');
  const cancelFinish = document.getElementById('cancelFinish');

  const cancelModal = document.getElementById('cancelModal');
  const finishModal = document.getElementById('finishModal');

  const addExerciseButton = document.getElementById('addExerciseButton');
  const programNameInput = document.getElementById('programName');
  const exercisesContainer = document.getElementById('exercisesContainer');
  const totalXPElement = document.getElementById('totalXP');
  const totalSetsElement = document.getElementById('totalSets');

  let exercises = []; // {exerciseData, sets, reps, weight}

  // Отмена
  cancelButton.addEventListener('click', () => {
    cancelModal.style.display = 'block';
  });

  confirmCancel.addEventListener('click', () => {
    window.location.href = 'training';
  });

  cancelCancel.addEventListener('click', () => {
    cancelModal.style.display = 'none';
  });

  // Завершить
  finishButton.addEventListener('click', () => {
    finishModal.style.display = 'block';
  });

  cancelFinish.addEventListener('click', () => {
    finishModal.style.display = 'none';
  });

  confirmFinish.addEventListener('click', () => {
    const programName = programNameInput.value.trim();
    if (!programName) {
      alert('Пожалуйста, введите название программы.');
      finishModal.style.display = 'none';
      return;
    }
    if (exercises.length === 0) {
      alert('Добавьте хотя бы одно упражнение.');
      finishModal.style.display = 'none';
      return;
    }

    const program = {
      id: Date.now().toString(),
      name: programName,
      exercises: exercises.map(e => ({
        exerciseId: e.exerciseData._id,
        sets: e.sets,
        reps: e.reps
      }))
    };

    let userPrograms = [];
    const storedPrograms = localStorage.getItem('userPrograms');
    if (storedPrograms) userPrograms = JSON.parse(storedPrograms);
    userPrograms.push(program);
    localStorage.setItem('userPrograms', JSON.stringify(userPrograms));

    alert('Программа успешно сохранена.');
    window.location.href = 'training';
  });

  // Добавить упражнение
  addExerciseButton.addEventListener('click', () => {
    // Переходим на addExercise и указываем что возвращаться надо в программу
    sessionStorage.setItem('returnTo', 'program');
    window.location.href = 'addExercise';
  });

  // Проверяем, пришли ли с addExercise.html
  const selectedExerciseJSON = sessionStorage.getItem('selectedExercise');
  if (selectedExerciseJSON) {
    const selectedExercise = JSON.parse(selectedExerciseJSON);
    addNewExercise(selectedExercise);
    sessionStorage.removeItem('selectedExercise');
  }

  function addNewExercise(exerciseData) {
    // По умолчанию sets=1, reps=10, weight=20
    const exercise = {
      exerciseData,
      sets: 1,
      reps: 10,
      weight: 20
    };
    exercises.push(exercise);
    renderExercises();
    updateStats();
  }

  function renderExercises() {
    exercisesContainer.innerHTML = '';
    exercises.forEach((ex, index) => {
      const { exerciseData, sets, reps, weight } = ex;
      const { totalXP, xpBreakdown } = calculateExerciseXP(exerciseData, sets, reps, weight);

      const exerciseCard = document.createElement('div');
      exerciseCard.className = 'exercise-card';

      const image = document.createElement('img');
      image.className = 'exercise-image';
      image.src = exerciseData.thumbnailUrl || 'images/icons/default-thumbnail.png';
      image.addEventListener('click', () => {
        window.location.href = `exercise.html?id=${exerciseData._id}`;
      });

      const detailsDiv = document.createElement('div');
      detailsDiv.className = 'exercise-details';

      const nameBlock = document.createElement('div');
      nameBlock.className = 'exercise-name-block';
      nameBlock.textContent = exerciseData.name;

      const inputsDiv = document.createElement('div');
      inputsDiv.className = 'exercise-inputs';

      const headerRow = document.createElement('div');
      headerRow.className = 'header-row';

      const setsHeader = document.createElement('div');
      setsHeader.className = 'header-item';
      setsHeader.textContent = 'ПОДХ.';

      const weightHeader = document.createElement('div');
      weightHeader.className = 'header-item';
      weightHeader.textContent = 'КГ.';

      const repsHeader = document.createElement('div');
      repsHeader.className = 'header-item';
      repsHeader.textContent = 'ПОВТ.';

      headerRow.appendChild(setsHeader);
      headerRow.appendChild(weightHeader);
      headerRow.appendChild(repsHeader);

      const inputRow = document.createElement('div');
      inputRow.className = 'input-row';

      const setsInput = document.createElement('input');
      setsInput.type = 'number';
      setsInput.className = 'set-input';
      setsInput.value = sets;
      setsInput.addEventListener('blur', () => {
        ex.sets = parseInt(setsInput.value) || 0;
        updateStats();
      });

      const weightInput = document.createElement('input');
      weightInput.type = 'number';
      weightInput.className = 'set-input';
      weightInput.value = weight;
      weightInput.addEventListener('blur', () => {
        ex.weight = parseFloat(weightInput.value) || 0;
        updateStats();
      });

      const repsInput = document.createElement('input');
      repsInput.type = 'number';
      repsInput.className = 'set-input';
      repsInput.value = reps;
      repsInput.addEventListener('blur', () => {
        ex.reps = parseInt(repsInput.value) || 0;
        updateStats();
      });

      inputRow.appendChild(setsInput);
      inputRow.appendChild(weightInput);
      inputRow.appendChild(repsInput);

      inputsDiv.appendChild(headerRow);
      inputsDiv.appendChild(inputRow);

      const buttonsRow = document.createElement('div');
      buttonsRow.className = 'buttons-row';

      const addSetButton = document.createElement('button');
      addSetButton.className = 'add-set-button';
      addSetButton.textContent = 'ДОБАВИТЬ';
      addSetButton.addEventListener('click', () => {
        ex.sets++;
        setsInput.value = ex.sets;
        updateStats();
      });

      const deleteExerciseButton = document.createElement('button');
      deleteExerciseButton.className = 'delete-exercise-button';
      deleteExerciseButton.textContent = 'УДАЛИТЬ';
      deleteExerciseButton.addEventListener('click', () => {
        if (ex.sets > 1) {
          ex.sets--;
          setsInput.value = ex.sets;
          updateStats();
        } else {
          exercises.splice(index, 1);
          updateStats();
        }
      });

      buttonsRow.appendChild(addSetButton);
      buttonsRow.appendChild(deleteExerciseButton);

      detailsDiv.appendChild(nameBlock);
      detailsDiv.appendChild(inputsDiv);
      detailsDiv.appendChild(buttonsRow);

      const xpBlock = document.createElement('div');
      xpBlock.className = 'xp-block';

      const levelLine = document.createElement('div');
      levelLine.className = 'xp-line';
      const xpVal = document.createElement('span');
      xpVal.className = 'xp-value';
      xpVal.textContent = `${totalXP} XP`;
      const levelLabel = document.createElement('span');
      levelLabel.className = 'xp-label';
      levelLabel.textContent = ' УРОВЕНЬ';
      levelLine.appendChild(xpVal);
      levelLine.appendChild(levelLabel);
      xpBlock.appendChild(levelLine);

      xpBreakdown.forEach(m => {
        const muscleLine = document.createElement('div');
        muscleLine.className = 'xp-line';
        const xpValM = document.createElement('span');
        xpValM.className = 'xp-value';
        xpValM.textContent = `${m.xp} XP`;
        const muscleName = document.createElement('span');
        muscleName.className = 'muscle-name';
        muscleName.textContent = ` ${m.muscle.toUpperCase()}`;
        muscleLine.appendChild(xpValM);
        muscleLine.appendChild(muscleName);
        xpBlock.appendChild(muscleLine);
      });

      exerciseCard.appendChild(image);
      exerciseCard.appendChild(detailsDiv);
      exerciseCard.appendChild(xpBlock);

      exercisesContainer.appendChild(exerciseCard);
    });
  }

  function updateStats() {
    let totalXP = 0;
    let totalSets = 0;
    exercises.forEach(ex => {
      const { totalXP: exXP } = calculateExerciseXP(ex.exerciseData, ex.sets, ex.reps, ex.weight);
      totalXP += exXP;
      totalSets += ex.sets;
    });

    totalXPElement.textContent = `${totalXP} XP`;
    totalSetsElement.textContent = totalSets;

    // Перерисуем упражнения
    renderExercises();
  }

  function calculateExerciseXP(exData, sets, reps, weight) {
    const minWeight = exData.minWeightMale || 20;
    const maxWeight = exData.maxWeightMale || 100;
    const rpe = 5; // фиксированный RPE=5
    let totalXP = 0;
    for (let i = 0; i < sets; i++) {
      let weightLevel;
      if (weight <= minWeight) weightLevel = 1;
      else if (weight >= maxWeight) weightLevel = 10;
      else {
        const ratio = (weight - minWeight) / (maxWeight - minWeight);
        weightLevel = Math.round(ratio * 9 + 1);
      }

      const rpeBonus = (rpe - 5)*0.05;
      const setXP = Math.round(weightLevel * reps * (1 + rpeBonus));
      totalXP += setXP;
    }

    const xpBreakdown = [];
    if (exData.musclePercentages && typeof exData.musclePercentages === 'object') {
      const entries = Object.entries(exData.musclePercentages);
      entries.sort((a,b) => b[1]-a[1]);
      entries.forEach(([muscle, pct]) => {
        const mxp = Math.round((totalXP * pct) / 100);
        xpBreakdown.push({ muscle, xp: mxp });
      });
    }

    return { totalXP, xpBreakdown };
  }

});
