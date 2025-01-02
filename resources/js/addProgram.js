document.addEventListener('DOMContentLoaded', () => {
    // ------------------------------------------------
    // Глобальные переменные
    // ------------------------------------------------
    const cancelButton       = document.getElementById('cancelButton');
    const finishButton       = document.getElementById('finishButton');
    const confirmCancel      = document.getElementById('confirmCancel');
    const cancelCancel       = document.getElementById('cancelCancel');
    const confirmFinish      = document.getElementById('confirmFinish');
    const cancelFinish       = document.getElementById('cancelFinish');
  
    const cancelModal        = document.getElementById('cancelModal');
    const finishModal        = document.getElementById('finishModal');
  
    const addExerciseButton  = document.getElementById('addExerciseButton');
    const programNameInput   = document.getElementById('programName');
    const exercisesContainer = document.getElementById('exercisesContainer');
    const totalXPElement     = document.getElementById('totalXP');
    const totalSetsElement   = document.getElementById('totalSets');
  
    // Массив упражнений: [{ exerciseData, sets, reps, weight }, ...]
    let exercises = [];
  
    // Данные пользователя (пол, вес и т.д.), полученные с бэка
    let userData = null;
  
    // ------------------------------------------------
    // 1) Сначала загружаем состояние из localStorage
    // ------------------------------------------------
    const savedProgramData = localStorage.getItem('tempProgramData');
    if (savedProgramData) {
      const parsed = JSON.parse(savedProgramData);
      programNameInput.value = parsed.name || '';
      exercises = parsed.exercises || [];
    }
  
    // ------------------------------------------------
    // 2) Загружаем данные пользователя (gender, weight)
    //    предполагаем, что есть endpoint /user/profile
    // ------------------------------------------------
    fetch('/profile', { method: 'GET' })
      .then(res => res.json())
      .then(data => {
        // Пример: data = { id: 123, gender: 'male', weight: 85, ... }
        userData = data;
        // После получения userData пересчитываем XP
        updateStats();
      })
      .catch(err => {
        console.error('Ошибка при получении данных пользователя:', err);
        // Даже если не удалось, пусть userData останется null
        // Тогда XP будет считаться по дефолтной логике
        updateStats();
      });
  
    // ------------------------------------------------
    // Функция сохранения в localStorage
    // ------------------------------------------------
    function saveLocalState() {
      const dataToSave = {
        name: programNameInput.value.trim(),
        exercises: exercises
      };
      localStorage.setItem('tempProgramData', JSON.stringify(dataToSave));
    }
  
    // ------------------------------------------------
    // Модальное окно «Отмена»
    // ------------------------------------------------
    cancelButton.addEventListener('click', () => {
      cancelModal.style.display = 'block';
    });
    confirmCancel.addEventListener('click', () => {
      window.location.href = 'training';
    });
    cancelCancel.addEventListener('click', () => {
      cancelModal.style.display = 'none';
    });
  
    // ------------------------------------------------
    // Модальное окно «Завершить»
    // ------------------------------------------------
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
  
      // Формируем тело запроса
      const payload = {
        name: programName,
        exercises: exercises.map(e => ({
            exerciseId: e.exerciseData.id,
          sets: e.sets,
          weight: e.weight,
          reps: e.reps
        }))
      };
  
      // Отправляем POST на /program/add
      console.log('Отправляем payload в /program/add:', payload);
      fetch('/program/add', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          // Если в Laravel включена защита CSRF:
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(payload),
      })
      .then(response => response.json())
      .then(data => {
        if (!data.message) {
          alert('Произошла ошибка при сохранении программы.');
          finishModal.style.display = 'none';
          return;
        }
        alert(data.message);
  
        // Если всё удачно, очищаем localStorage
        localStorage.removeItem('tempProgramData');
        // и переходим на страницу training
        window.location.href = 'training';
      })
      .catch(err => {
        console.error(err);
        alert('Ошибка при отправке данных на сервер.');
        finishModal.style.display = 'none';
      });
    });
  
    // ------------------------------------------------
    // Кнопка «Добавить упражнение»
    // ------------------------------------------------
    addExerciseButton.addEventListener('click', () => {
      // Запоминаем, что после addExercise.html надо вернуться на эту страницу
      sessionStorage.setItem('returnTo', 'program');
      window.location.href = 'addExercise';
    });
  
    // ------------------------------------------------
    // Если вернулись с addExercise.html, ловим выбранное упражнение
    // ------------------------------------------------
    const selectedExerciseJSON = sessionStorage.getItem('selectedExercise');
    if (selectedExerciseJSON) {
      const selectedExercise = JSON.parse(selectedExerciseJSON);
      addNewExercise(selectedExercise);
      sessionStorage.removeItem('selectedExercise');
    }
  
    // ------------------------------------------------
    // Добавляет новое упражнение в массив
    // ------------------------------------------------
    function addNewExercise(exerciseData) {
        console.log("Добавляем упражнение:", exerciseData);
      // По умолчанию 1 подход, 10 повторов, 20 кг
      const exercise = {
        exerciseData,
        sets: 1,
        reps: 10,
        weight: 20
      };
      exercises.push(exercise);
      updateStats();
      saveLocalState();
    }
  
    // ------------------------------------------------
    // Перерисовка карточек упражнений
    // ------------------------------------------------
    function renderExercises() {
      exercisesContainer.innerHTML = '';
      exercises.forEach((ex, index) => {
        const { exerciseData, sets, reps, weight } = ex;
        const { totalXP, xpBreakdown } = calculateExerciseXP(exerciseData, sets, reps, weight);
  
        const exerciseCard = document.createElement('div');
        exerciseCard.className = 'exercise-card';
  
        // Картинка (миниатюра)
        const image = document.createElement('img');
        image.className = 'exercise-image';
        image.src = exerciseData.thumbnailUrl || 'images/icons/default-thumbnail.png';
        // Клик => переходим на страницу упражнения
        image.addEventListener('click', () => {
          window.location.href = `exercise?id=${exerciseData._id}`;
        });
  
        // Блок деталей
        const detailsDiv = document.createElement('div');
        detailsDiv.className = 'exercise-details';
  
        // Название
        const nameBlock = document.createElement('div');
        nameBlock.className = 'exercise-name-block';
        nameBlock.textContent = exerciseData.name;
  
        // Вводы (количество подходов, вес, повторы)
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
          saveLocalState();
        });
  
        const weightInput = document.createElement('input');
        weightInput.type = 'number';
        weightInput.className = 'set-input';
        weightInput.value = weight;
        weightInput.addEventListener('blur', () => {
          ex.weight = parseFloat(weightInput.value) || 0;
          updateStats();
          saveLocalState();
        });
  
        const repsInput = document.createElement('input');
        repsInput.type = 'number';
        repsInput.className = 'set-input';
        repsInput.value = reps;
        repsInput.addEventListener('blur', () => {
          ex.reps = parseInt(repsInput.value) || 0;
          updateStats();
          saveLocalState();
        });
  
        inputRow.appendChild(setsInput);
        inputRow.appendChild(weightInput);
        inputRow.appendChild(repsInput);
  
        inputsDiv.appendChild(headerRow);
        inputsDiv.appendChild(inputRow);
  
        // Кнопки «Добавить» / «Удалить»
        const buttonsRow = document.createElement('div');
        buttonsRow.className = 'buttons-row';
  
        const addSetButton = document.createElement('button');
        addSetButton.className = 'add-set-button';
        addSetButton.textContent = 'ДОБАВИТЬ';
        addSetButton.addEventListener('click', () => {
          ex.sets++;
          setsInput.value = ex.sets;
          updateStats();
          saveLocalState();
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
          saveLocalState();
        });
  
        buttonsRow.appendChild(addSetButton);
        buttonsRow.appendChild(deleteExerciseButton);
  
        detailsDiv.appendChild(nameBlock);
        detailsDiv.appendChild(inputsDiv);
        detailsDiv.appendChild(buttonsRow);
  
        // Блок XP
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
  
        // Детализация по мышцам (если есть musclePercentages)
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
  
    // ------------------------------------------------
    // Пересчитываем общий XP и перерисовываем
    // ------------------------------------------------
    function updateStats() {
      let totalXP   = 0;
      let totalSets = 0;
  
      exercises.forEach(ex => {
        const { totalXP: exXP } = calculateExerciseXP(
          ex.exerciseData,
          ex.sets,
          ex.reps,
          ex.weight
        );
        totalXP   += exXP;
        totalSets += ex.sets;
      });
  
      totalXPElement.textContent   = `${totalXP} XP`;
      totalSetsElement.textContent = totalSets;
  
      renderExercises();
    }
  
    // ------------------------------------------------
    // Функция расчёта XP (аналогичная calculateSetXP)
    // ------------------------------------------------
    function calculateExerciseXP(exData, sets, reps, weight) {
      // Если не удалось получить userData, возьмём значения по умолчанию
      // (gender=male, weight=70)
      const gender    = (userData && userData.gender === 'female') ? 'female' : 'male';
      const avgWeight = (gender === 'female') ? 60 : 70;
      const userWeight= (userData && userData.weight) ? userData.weight : avgWeight;
      const factor    = userWeight / avgWeight;
  
      // min/max из упражнения
      let minW = (gender === 'male')
        ? (exData.minWeightMale || 20)
        : (exData.minWeightFemale || 20);
  
      let maxW = (gender === 'male')
        ? (exData.maxWeightMale || 100)
        : (exData.maxWeightFemale || 100);
  
      // Корректируем под вес пользователя
      const adjMin = minW * factor;
      const adjMax = maxW * factor;
  
      // Аналог calculateWeightLevel(...) из бэка
      function getWeightLevel(w) {
        if (w <= adjMin) return 1;
        if (w >= adjMax) return 10;
        const ratio = (w - adjMin) / (adjMax - adjMin);
        return Math.round(ratio * 9 + 1);
      }
  
      let totalXP = 0;
      // Пускай в интерфейсе RPE=5 (фикс)
      const rpe = 5;
  
      for (let i = 0; i < sets; i++) {
        const weightLevel = getWeightLevel(weight);
        const baseXP      = weightLevel * reps;
  
        // RPE-бонус
        let rpeBonus = 0;
        if (rpe > 5) {
          const percent = (rpe - 5) * 0.05;
          rpeBonus = baseXP * percent;
        }
  
        // Мульти-фактор за большое число повторов
        let multiRepFactor = 1.0;
        if (reps >= 13 && reps <= 15) {
          multiRepFactor = 0.8;
        } else if (reps >= 16) {
          multiRepFactor = 0.5;
        }
  
        const setXP = Math.round((baseXP + rpeBonus) * multiRepFactor);
        totalXP += setXP;
      }
  
      // Распределение XP по мышцам (если есть musclePercentages)
      const xpBreakdown = [];
      if (exData.musclePercentages && typeof exData.musclePercentages === 'object') {
        const entries = Object.entries(exData.musclePercentages);
        // Сортируем от большей доли к меньшей
        entries.sort((a, b) => b[1] - a[1]);
        entries.forEach(([muscle, pct]) => {
          const mxp = Math.round((totalXP * pct) / 100);
          xpBreakdown.push({ muscle, xp: mxp });
        });
      }
  
      return { totalXP, xpBreakdown };
    }
  
    // Первичная отрисовка (если userData придёт позже — оно всё равно перерисуется заново)
    updateStats();
  });
  