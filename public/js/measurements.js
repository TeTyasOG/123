document.addEventListener('DOMContentLoaded', () => {
  const backButton = document.getElementById('backButton');
  const addButton = document.getElementById('addButton');
  const measurementsHistory = document.getElementById('measurementsHistory');

  const addMeasurementsModal = document.getElementById('addMeasurementsModal');
  const cancelModalButton = document.getElementById('cancelModalButton');
  const applyChangesButton = document.getElementById('applyChangesButton');
  const measurementsForm = document.getElementById('measurementsForm');

  const measurementParameters = [
    'Масса тела (кг)',
    'Талия (см)',
    'Содержание жира (%)',
    'Шея (см)',
    'Плечи (см)',
    'Грудь (см)',
    'Левый бицепс (см)',
    'Правый бицепс (см)',
    'Левое предплечье (см)',
    'Правое предплечье (см)',
    'Живот (см)',
    'Ягодицы (см)',
    'Левое бедро (см)',
    'Правое бедро (см)',
    'Левая икра (см)',
    'Правая икра (см)'
  ];

  let measurementsData = []; // Массив всех замеров
  let userData = {};

  backButton.addEventListener('click', () => {
    window.location.href = 'profile';
  });

  addButton.addEventListener('click', () => {
    openAddMeasurementsModal();
  });

  function openAddMeasurementsModal() {
    measurementsForm.innerHTML = '';
    measurementParameters.forEach(param => {
      const containerDiv = document.createElement('div');
      containerDiv.className = 'measurement-field-container';

      const label = document.createElement('label');
      label.textContent = param;

      const input = document.createElement('input');
      input.type = 'number';
      input.step = '0.1';
      input.name = param;

      containerDiv.appendChild(label);
      containerDiv.appendChild(input);
      measurementsForm.appendChild(containerDiv);
    });

    addMeasurementsModal.style.display = 'block';
  }

  cancelModalButton.addEventListener('click', () => {
    addMeasurementsModal.style.display = 'none';
  });

  applyChangesButton.addEventListener('click', async () => {
    const inputs = measurementsForm.querySelectorAll('input');
    const measurementEntry = {
      date: new Date().toISOString(),
      measurements: {}
    };

    inputs.forEach(input => {
      if (input.value) {
        measurementEntry.measurements[input.name] = parseFloat(input.value);
      }
    });

    if (Object.keys(measurementEntry.measurements).length > 0) {
      try {
        const response = await fetch('/addMeasurement', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(measurementEntry)
        });

        if (response.ok) {
          await loadMeasurementsFromServer();
          addMeasurementsModal.style.display = 'none';
          // Если указан вес тела, обновляем вес
          if (measurementEntry.measurements['Масса тела (кг)']) {
            userData.weight = measurementEntry.measurements['Масса тела (кг)'];
          }
        } else {
          console.error('Ошибка при сохранении замера на сервере.');
          // Можно показать модалку ошибки, если нужно
        }
      } catch (error) {
        console.error('Ошибка сети:', error);
        // Можно показать модалку ошибки, если нужно
      }
    } else {
      // Можно сделать модальное уведомление о том, что нужно ввести хотя бы один параметр.
      // Для простоты оставим alert:
      alert('Пожалуйста, введите хотя бы один замер.');
    }
  });

  addMeasurementsModal.addEventListener('click', (event) => {
    if (event.target === addMeasurementsModal) {
      addMeasurementsModal.style.display = 'none';
    }
  });

  function renderMeasurementsHistory() {
    measurementsHistory.innerHTML = '';
    if (measurementsData.length === 0) {
      // Если нет замеров
      const noData = document.createElement('p');
      noData.textContent = 'Нет данных о замерах.';
      measurementsHistory.appendChild(noData);
      return;
    }

    measurementsData.forEach((entry, index) => {
      const entryDiv = document.createElement('div');
      entryDiv.className = 'measurement-entry';

      // Заголовок с датой
      const headerDiv = document.createElement('div');
headerDiv.className = 'measurement-header';

// Добавляем дату в заголовок
const dateDiv = document.createElement('div');
dateDiv.className = 'measurement-date';
const formattedDate = new Date(entry.date).toLocaleDateString('ru-RU');
dateDiv.textContent = formattedDate;

headerDiv.appendChild(dateDiv);
entryDiv.appendChild(headerDiv); // Добавляем заголовок в общий блок


      // Список замеров
      const ul = document.createElement('ul');
      ul.className = 'measurement-list';

      let previousMeasurements = null;
      if (index < measurementsData.length - 1) {
        previousMeasurements = measurementsData.slice(index + 1);
      }

      for (const param in entry.measurements) {
        const li = document.createElement('li');

        const nameSpan = document.createElement('span');
        nameSpan.className = 'measurement-name';
        nameSpan.textContent = param;

        const valueSpan = document.createElement('span');
        valueSpan.className = 'measurement-value';
        valueSpan.textContent = entry.measurements[param];

        const changeImg = document.createElement('img');
        changeImg.className = 'measurement-change';

        let previousValue = null;
        if (previousMeasurements) {
          for (let i = 0; i < previousMeasurements.length; i++) {
            if (previousMeasurements[i].measurements &&
                previousMeasurements[i].measurements[param] !== undefined) {
              previousValue = previousMeasurements[i].measurements[param];
              break;
            }
          }
        }

        if (previousValue !== null) {
          if (entry.measurements[param] > previousValue) {
            changeImg.src = 'images/icons/arrow_up.png';
          } else if (entry.measurements[param] < previousValue) {
            changeImg.src = 'images/icons/arrow_down.png';
          } else {
            changeImg.src = 'images/icons/arrow_equal.png';
          }
        } else {
          changeImg.src = 'images/icons/arrow_new.png';
        }

        li.appendChild(nameSpan);
        li.appendChild(valueSpan);
        li.appendChild(changeImg);
        ul.appendChild(li);
      }

      entryDiv.appendChild(ul);
      measurementsHistory.appendChild(entryDiv);

    });
  }

  async function loadMeasurementsFromServer() {
    try {
      const response = await fetch('/getMeasurements');
      if (response.ok) {
        measurementsData = await response.json();
        renderMeasurementsHistory();
      } else {
        console.error('Ошибка при загрузке замеров с сервера.');
      }
    } catch (error) {
      console.error('Ошибка сети:', error);
    }
  }

  async function loadUserDataFromServer() {
    try {
      const response = await fetch('/getUserProfile');
      if (response.ok) {
        userData = await response.json();
      } else {
        console.error('Ошибка при загрузке данных пользователя.');
      }
    } catch (error) {
      console.error('Ошибка сети:', error);
    }
  }

  async function init() {
    await loadUserDataFromServer();
    await loadMeasurementsFromServer();
  }

  init();
});
