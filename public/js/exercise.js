// public/js/exercise.js

document.addEventListener('DOMContentLoaded', async () => {
  const urlParams = new URLSearchParams(window.location.search);
  const exerciseId = urlParams.get('id');

  if (!exerciseId) {
    alert('Идентификатор упражнения не указан.');
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
      const response = await fetch(`/exerciseInfo?id=${exerciseId}`);
      if (!response.ok) {
        alert('Ошибка при загрузке информации об упражнении.');
        return;
      }

      const data = await response.json();

      exerciseNameElem.textContent = data.name.toUpperCase();

      // Настраиваем видео (gif-like behavior)
      videoElem.src = data.videoUrl;
      videoElem.loop = true;
      videoElem.muted = true;
      videoElem.play();

      videoElem.addEventListener('click', () => {
        if (videoElem.paused) {
          videoElem.play();
        } else {
          videoElem.pause();
        }
      });

      const muscleEntries = Object.entries(data.musclePercentages || {}).sort((a,b) => b[1]-a[1]);
      if (muscleEntries.length > 0) {
        const mainMuscle = muscleEntries[0][0];
        mainMuscleElem.textContent = `ОСНОВНАЯ: ${mainMuscle.toUpperCase()}`;
        if (muscleEntries.length > 1) {
          const additional = muscleEntries.slice(1).map(m => m[0].toUpperCase()).join(', ');
          additionalMusclesElem.textContent = `ДОПОЛНИТЕЛЬНАЯ: ${additional}`;
        } else {
          additionalMusclesElem.textContent = `ДОПОЛНИТЕЛЬНАЯ: НЕТ`;
        }
      } else {
        mainMuscleElem.textContent = 'ОСНОВНАЯ: НЕТ';
        additionalMusclesElem.textContent = 'ДОПОЛНИТЕЛЬНАЯ: НЕТ';
      }

      const xp = data.userExerciseXP || 0;
      let rankName = 'НЕТУ';
      let rankColor = '#ffffff';
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

      bestWeightVal.textContent = data.bestWeight || 0;
      bestWeightUnit.textContent = 'КГ';
      bestLevelVal.textContent = data.bestWeightLevel || 0;
      bestLevelUnit.textContent = 'ЛВЛ';
      bestXPVal.textContent = data.bestXP || 0;
      bestXPUnit.textContent = 'ОП';

      if (data.description && data.description.trim() !== '') {
        descriptionElem.textContent = data.description;
      } else {
        descriptionElem.textContent = 'Нет описания.';
      }

      if (data.tips && data.tips.length > 0) {
        tipsElem.innerHTML = '';
        data.tips.forEach(t => {
          const li = document.createElement('li');
          li.textContent = t;
          tipsElem.appendChild(li);
        });
      } else {
        tipsElem.innerHTML = '<li>Нет советов.</li>';
      }

    } catch (error) {
      console.error('Ошибка:', error);
    }
  }

  await loadExerciseInfo();
});
