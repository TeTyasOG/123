document.addEventListener('DOMContentLoaded', () => {
  const modalOverlay = document.getElementById('modalOverlay');
  const modalText = document.getElementById('modalText');
  const modalOkButton = document.getElementById('modalOkButton');
  const workoutListDiv = document.getElementById('workoutList');
  const backButton = document.getElementById('backButton');

  function showModal(text) {
    modalText.textContent = text;
    modalOverlay.style.display = 'block';

    // Закрытие по кнопке "ОК"
    modalOkButton.addEventListener('click', closeModal);

    // Закрытие при клике на фон
    modalOverlay.addEventListener('click', function overlayHandler(e) {
      if (e.target === modalOverlay) {
        closeModal();
        modalOverlay.removeEventListener('click', overlayHandler); // Убираем обработчик после закрытия
      }
    });
  }

  function closeModal() {
    modalOverlay.style.display = 'none';
  }

  backButton.addEventListener('click', () => {
    window.location.href = 'profile';
  });

  async function loadWorkouts() {

    try {
      const response = await fetch('/getWorkouts'); // Предполагается, что маршрут возвращает список завершённых тренировок
      if (response.ok) {
        const workouts = await response.json();

        displayWorkouts(workouts);
      } else if (response.status === 401) {
        showModal('Требуется авторизация. Пожалуйста, войдите в систему.');
        window.location.href = '/login';
      } else {
        console.error('Ошибка при загрузке тренировок. Статус:', response.status);
        showModal('Ошибка при загрузке тренировок.');
      }
    } catch (error) {
      console.error('Ошибка:', error);
      showModal('Ошибка при загрузке тренировок.');
    }
  }

  function getDayOfWeek(date) {
    const days = ['Воскресенье','Понедельник','Вторник','Среда','Четверг','Пятница','Суббота'];
    return days[date.getDay()];
  }

  // Функция для отображения списка тренировок
  function displayWorkouts(workouts) {
    if (!workouts || workouts.length === 0) {
      workoutListDiv.textContent = 'У вас нет сохранённых тренировок.';
      return;
    }

    workoutListDiv.innerHTML = '';
    workouts.forEach((workout, index) => {
      // Предполагаем, что в объекте workout есть поля:
      // workout.date - дата тренировки
      // workout.totalWorkoutTime - строка времени вида "14Ч 6М 23С"
      // workout.totalXP - число полученного опыта
      // workout.exercisesCount - число упражнений
      // Если таких полей нет, нужно их добавить или рассчитать при завершении тренировки на сервере.

      const dateObj = new Date(workout.date);
      const dateStr = dateObj.toLocaleDateString();
      const dayOfWeek = getDayOfWeek(dateObj).toUpperCase();
      const dateUpper = dateStr.toUpperCase(); // Дата верхним регистром

      const workoutDiv = document.createElement('div');
      workoutDiv.className = 'workout-card';

      // День недели
      const dayElem = document.createElement('div');
      dayElem.className = 'workout-day';
      dayElem.textContent = dayOfWeek;

      // Дата
      const dateElem = document.createElement('div');
      dateElem.className = 'workout-date';
      dateElem.textContent = dateUpper;

      // Блок с информацией о времени, опыте и упражнениях
      const infoDiv = document.createElement('div');
      infoDiv.className = 'workout-info';

      // Время
      const timeCol = document.createElement('div');
      timeCol.className = 'info-column';
      const timeLabel = document.createElement('div');
      timeLabel.className = 'info-column-label';
      timeLabel.textContent = 'ВРЕМЯ';
      const timeValue = document.createElement('div');
      timeValue.className = 'info-column-value info-time-value';
      timeValue.textContent = workout.total_workout_time || '0С';  // Если нет данных, показать 0С
      timeCol.appendChild(timeLabel);
      timeCol.appendChild(timeValue);

      // Опыт
      const xpCol = document.createElement('div');
      xpCol.className = 'info-column';
      const xpLabel = document.createElement('div');
      xpLabel.className = 'info-column-label';
      xpLabel.textContent = 'ОПЫТ';
      const xpVal = document.createElement('div');
      xpVal.className = 'info-column-value info-xp-value';
      xpVal.textContent = `${workout.total_experience || 0} XP`;  // Если нет данных, 0 XP
      xpCol.appendChild(xpLabel);
      xpCol.appendChild(xpVal);

      // Упражнения
      const exercisesCol = document.createElement('div');
      exercisesCol.className = 'info-column';
      const exercisesLabel = document.createElement('div');
      exercisesLabel.className = 'info-column-label';
      exercisesLabel.textContent = 'УПРАЖНЕНИЙ';
      const exercisesVal = document.createElement('div');
      exercisesVal.className = 'info-column-value info-exercises-value';
      exercisesVal.textContent = workout.exercisesCount || workout.exercises?.length || 0; 
      exercisesCol.appendChild(exercisesLabel);
      exercisesCol.appendChild(exercisesVal);

      infoDiv.appendChild(timeCol);
      infoDiv.appendChild(xpCol);
      infoDiv.appendChild(exercisesCol);

      workoutDiv.appendChild(dayElem);
      workoutDiv.appendChild(dateElem);
      workoutDiv.appendChild(infoDiv);

      // Добавляем разделитель, если это не последний элемент
      if (index < workouts.length - 1) {
        const divider = document.createElement('hr');
        divider.className = 'workout-card-divider';
        workoutDiv.appendChild(divider);
      }

      // При клике на карточку переходим к деталям
      workoutDiv.addEventListener('click', () => {
        window.location.href = `/workout_detail?id=${workout.id}`;
      });

      workoutListDiv.appendChild(workoutDiv);
    });
  }

  loadWorkouts();
});
