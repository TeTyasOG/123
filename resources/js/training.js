document.addEventListener('DOMContentLoaded', () => {
  const startWorkoutButton = document.getElementById('startWorkoutButton');
  const createProgramButton = document.getElementById('createProgramButton');
  const programList = document.getElementById('programList');

  const startProgramModal = document.getElementById('startProgramModal');
  const startProgramMessage = document.getElementById('startProgramMessage');
  const confirmStartProgram = document.getElementById('confirmStartProgram');
  const cancelStartProgram = document.getElementById('cancelStartProgram');

  let userPrograms = [];
  let selectedProgramToStart = null;

  // Нажатие на кнопку "НАЧАТЬ ТРЕНИРОВКУ" — начинаем тренировку без программы
  startWorkoutButton.addEventListener('click', () => {
    sessionStorage.removeItem('currentProgramWorkout');
    // Чтобы при добавлении упражнений мы возвращались в тренировку
    sessionStorage.setItem('returnTo', 'workout');
    window.location.href = 'workout';
  });

  // Нажатие на кнопку "СОЗДАТЬ ПРОГРАММУ"
  createProgramButton.addEventListener('click', () => {
    sessionStorage.setItem('returnTo', 'program');
    window.location.href = 'addProgram';
  });

  // Загрузка программ пользователя 
  function loadPrograms() {
    fetch('/program/list', { credentials: 'include' })
      .then(res => res.json())
      .then(programs => {
        userPrograms = programs;
        console.log('От сервера /program/list получили:', programs);
        displayPrograms(programs);
      })
      .catch(err => {
        console.error('Ошибка при получении списка программ:', err);
        userPrograms = [];
        displayPrograms([]);
      });
  }
  

  // Функция для получения количества выполнений программы
  function getProgramCompletions(programId) {
    const key = `programCompletions_${programId}`;
    const val = localStorage.getItem(key);
    return val ? parseInt(val) : 0;
  }

  // Рассчёт XP для программы (упрощённо: сумма sets*reps всех упражнений)
  function calculateProgramXP(program) {
    let totalXP = 0;
    program.exercises.forEach(ex => {
      totalXP += ex.sets * ex.reps;
    });
    return totalXP;
  }

  // Отображение списка программ
  function displayPrograms(programs) {
    programList.innerHTML = '';
    programs.forEach(program => {
      // program.id
      // program.name
      // program.experience
      // program.times_completed
  
      const div = document.createElement('div');
      div.className = 'program-item';
      div.innerHTML = `
        <h3>${program.name}</h3>
        <div class="program-stats-row">
          <div class="program-stat-block">
            <div class="program-stat-label">ВЫПОЛН.</div>
            <div class="program-stat-value">${program.times_completed || 0}</div>
          </div>
          <div class="program-stat-block">
            <div class="program-stat-label">ОПЫТ</div>
            <div class="program-stat-value xp-value">${program.experience || 0}</div>
          </div>
        </div>
      `;
  
      // Клик на программу => начать тренировку (или открыть модалку "начать?")
      div.addEventListener('click', () => {
        selectedProgramToStart = program;
        startProgramMessage.textContent = `ВЫ ХОТИТЕ ЗАПУСТИТЬ ПРОГРАММУ "${program.name.toUpperCase()}"?`;
        startProgramModal.style.display = 'block';
      });
      
      programList.appendChild(div);
    });
  }
  

  confirmStartProgram.addEventListener('click', () => {
    if (selectedProgramToStart) {
        // Записываем в sessionStorage
        sessionStorage.setItem('currentProgramWorkout', JSON.stringify(selectedProgramToStart));
        sessionStorage.setItem('returnTo', 'workout');

        // <-- Добавим флажок «пропустить загрузку прошлых сетов»
        sessionStorage.setItem('skipPreviousSets', 'true');

        // Переходим на страницу workout
        window.location.href = 'workout';
    }
});


  cancelStartProgram.addEventListener('click', () => {
    startProgramModal.style.display = 'none';
    selectedProgramToStart = null;
  });

  // Инициализация
  loadPrograms();
});
