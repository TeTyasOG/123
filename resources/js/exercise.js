document.addEventListener('DOMContentLoaded', async () => {

  const modalOverlay = document.getElementById('modalOverlay');
  const modalText = document.getElementById('modalText');
  const modalOkButton = document.getElementById('modalOkButton');
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  const urlParams = new URLSearchParams(window.location.search);
  const exerciseId = urlParams.get('id');

  function showModal(text) {
    modalText.textContent = text;
    modalOverlay.style.display = 'block';

    modalOkButton.addEventListener('click', closeModal);
    modalOverlay.addEventListener('click', function overlayHandler(e) {
      if (e.target === modalOverlay) {
        closeModal();
        modalOverlay.removeEventListener('click', overlayHandler);
      }
    });
  }

  function closeModal() {
    modalOverlay.style.display = 'none';
  }

  if (!exerciseId) {
    showModal('Идентификатор упражнения не указан.');
    return;
  }
 
    
  const backButton = document.getElementById('backButton');
  const videoElem = document.getElementById('exerciseVideo');
  const exerciseNameElem = document.getElementById('exerciseName');
  const mainMuscleElem = document.getElementById('mainMuscle');
  const additionalMusclesElem = document.getElementById('additionalMuscles');
  const rankBoxElem = document.getElementById('rankBox');
  const bestWeightVal = document.getElementById('bestWeightVal');
  const bestWeightUnit = document.getElementById('bestWeightUnit');
  const bestLevelVal = document.getElementById('bestLevelVal');
  const bestLevelUnit = document.getElementById('bestLevelUnit');
  const bestXPVal = document.getElementById('bestXPVal');
  const bestXPUnit = document.getElementById('bestXPUnit');
  const descriptionElem = document.getElementById('descriptionText');
  const tipsElem = document.getElementById('tipsList');
    
  backButton.addEventListener('click', () => {
    window.history.back();
  });
    
  async function loadExerciseInfo() {
    try {
      const response = await fetch(`/exerciseInfo?id=${exerciseId}`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken, // Добавляем CSRF токен
        },
        credentials: 'include', // Для передачи сессионных куки
      });

      if (!response.ok) {
        showModal('Ошибка при загрузке информации об упражнении.');
        return;
      }

      const data = await response.json();


      // Название упражнения
      exerciseNameElem.textContent = (data.name || '').toUpperCase();
    
      // Настраиваем «gif-like» видео
      videoElem.src = data.videoUrl || '';
      videoElem.loop = true;
      videoElem.muted = true;
      videoElem.play().catch(err => console.warn('Автозапуск видео заблокирован', err));

      videoElem.addEventListener('click', () => {
        if (videoElem.paused) {
          videoElem.play();
        } else {
          videoElem.pause();
        }
      });
    
      /**
       * 1) ОТОБРАЖЕНИЕ МЫШЦ
       *    Теперь основная мышца и дополнительные берём из массива muscleFilters.
       *    Первая в списке — ОСНОВНАЯ, остальные — ДОПОЛНИТЕЛЬНАЯ.
       */
      const filters = Array.isArray(data.muscleFilters) ? data.muscleFilters : [];
      if (filters.length > 0) {
        const main = filters[0];
        mainMuscleElem.textContent = `ОСНОВНАЯ: ${main.toUpperCase()}`;

        if (filters.length > 1) {
          const additional = filters.slice(1).map(f => f.toUpperCase()).join(', ');
          additionalMusclesElem.textContent = `ДОПОЛНИТЕЛЬНАЯ: ${additional}`;
        } else {
          additionalMusclesElem.textContent = 'ДОПОЛНИТЕЛЬНАЯ: НЕТ';
        }
      } else {
        mainMuscleElem.textContent = 'ОСНОВНАЯ: НЕТ';
        additionalMusclesElem.textContent = 'ДОПОЛНИТЕЛЬНАЯ: НЕТ';
      }

      /**
       * 2) РАНГ (ЗВАНИЕ), основанный на XP
       */
      const xp = data.userExerciseXP || 0;
      let rankName = 'НЕТУ';
      let rankColor = '#ffffff'; // По умолчанию — белый

      if (xp >= 15000) {
        rankName = 'DIAMOND';
        rankColor = '#70d1f4';
      } else if (xp >= 7000) {
        rankName = 'GOLD';
        rankColor = '#ffd700';
      } else if (xp >= 2500) {
        rankName = 'SILVER';
        rankColor = '#c0c0c0';
      } else if (xp >= 500) {
        rankName = 'BRONZE';
        rankColor = '#bf8970';
      }

      rankBoxElem.style.backgroundColor = rankColor;
      rankBoxElem.innerHTML = `<span class="rank-text">${rankName}</span>`;

      /**
       * 3) «ЛУЧШИЕ» ПОКАЗАТЕЛИ: вес, уровень, XP
       */
      bestWeightVal.textContent = data.bestWeight || 0;
      bestWeightUnit.textContent = 'КГ';
      bestLevelVal.textContent = data.bestWeightLevel || 0;
      bestLevelUnit.textContent = 'ЛВЛ';
      bestXPVal.textContent = data.bestXP || 0;
      bestXPUnit.textContent = 'ОП';

      /**
       * 4) ОПИСАНИЕ
       */
      if (data.description && data.description.trim() !== '') {
        descriptionElem.textContent = data.description;
      } else {
        descriptionElem.textContent = 'Нет описания.';
      }

      /**
       * 5) СОВЕТЫ (новый способ отображения)
       *    Предполагается, что в data.tips хранится массив объектов [{ id, content }, ...].
       *    Если у вас только строки, адаптируйте под это.
       */
      if (Array.isArray(data.tips) && data.tips.length > 0) {
        tipsElem.innerHTML = '';
        data.tips.forEach(tip => {
          const li = document.createElement('li');

          // Если tip — это объект { id, content }, выводим tip.content
          // Если tip — это просто строка, делаем li.textContent = tip.
          // В примере предполагаем, что это объект:
          li.innerHTML = `
            <div class="tip-item">
              <span class="tip-content">${tip.content}</span>
            </div>
          `;
          tipsElem.appendChild(li);
        });
      } else {
        tipsElem.innerHTML = '<li>Нет советов.</li>';
      }

    } catch (error) {
      console.error('Ошибка:', error);
      showModal('Произошла ошибка при загрузке информации об упражнении.');
    }
  }

  await loadExerciseInfo();
});
