document.addEventListener('DOMContentLoaded', () => {
  const modalOverlay = document.getElementById('modalOverlay');
  const modalText = document.getElementById('modalText');
  const modalOkButton = document.getElementById('modalOkButton');

  const backButton = document.getElementById('backButton');
  const addButton = document.getElementById('addButton');
  const measurementsHistory = document.getElementById('measurementsHistory');

  const addMeasurementsModal = document.getElementById('addMeasurementsModal');
  const cancelModalButton = document.getElementById('cancelModalButton');
  const applyChangesButton = document.getElementById('applyChangesButton');
  const measurementsForm = document.getElementById('measurementsForm');

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
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const response = await fetch('/addMeasurement', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
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
          showModal('Ошибка при сохранении замера на сервере.');
          // Можно показать модалку ошибки, если нужно
        }
      } catch (error) {
        showModal('Ошибка сети. Пожалуйста, проверьте соединение.');
        // Можно показать модалку ошибки, если нужно
      }
    } else {
      // Можно сделать модальное уведомление о том, что нужно ввести хотя бы один параметр.
      // Для простоты оставим alert:
      showModal('Пожалуйста, введите хотя бы один замер.');
    }
  });

  addMeasurementsModal.addEventListener('click', (event) => {
    if (event.target === addMeasurementsModal) {
      addMeasurementsModal.style.display = 'none';
    }
  });

  function renderMeasurementsHistory() {
    // Сортируем данные по уникальному идентификатору id в порядке возрастания
    measurementsData.sort((a, b) => a.id - b.id);

    measurementsHistory.innerHTML = '';
    if (measurementsData.length === 0) {
        const noData = document.createElement('p');
        noData.textContent = 'Нет данных о замерах.';
        measurementsHistory.appendChild(noData);
        return;
    }

    // Храним последние значения каждого параметра
    const lastValues = {};

    // Идём по записям снизу вверх
    measurementsData.forEach((entry) => {
        const entryDiv = document.createElement('div');
        entryDiv.className = 'measurement-entry';

        // Заголовок с датой
        const headerDiv = document.createElement('div');
        headerDiv.className = 'measurement-header';

        const dateDiv = document.createElement('div');
        dateDiv.className = 'measurement-date';
        const formattedDate = new Date(entry.date).toLocaleDateString('ru-RU');
        dateDiv.textContent = formattedDate;

        headerDiv.appendChild(dateDiv);
        entryDiv.appendChild(headerDiv);

        // Список замеров
        const ul = document.createElement('ul');
        ul.className = 'measurement-list';

        Object.entries(entry.measurements).forEach(([name, value]) => {
            const li = document.createElement('li');

            const nameSpan = document.createElement('span');
            nameSpan.className = 'measurement-name';
            nameSpan.textContent = name;

            const valueSpan = document.createElement('span');
            valueSpan.className = 'measurement-value';
            valueSpan.textContent = value;

            const changeImg = document.createElement('img');
            changeImg.className = 'measurement-change';

            // Проверяем изменения относительно последнего значения
            if (lastValues[name] === undefined) {
                changeImg.src = 'images/icons/arrow_new.png'; // Новый параметр
            } else {
                const lastValue = lastValues[name];
                if (value > lastValue) {
                    changeImg.src = 'images/icons/arrow_up.png'; // Замер увеличился
                } else if (value < lastValue) {
                    changeImg.src = 'images/icons/arrow_down.png'; // Замер уменьшился
                } else {
                    changeImg.src = 'images/icons/arrow_equal.png'; // Замер остался неизменным
                }
            }

            // Обновляем последнее значение параметра
            lastValues[name] = value;

            li.appendChild(nameSpan);
            li.appendChild(valueSpan);
            li.appendChild(changeImg);
            ul.appendChild(li);
        });

        entryDiv.appendChild(ul);
        measurementsHistory.appendChild(entryDiv);
    });

    // Перевернуть историю после рендера, чтобы показывать новые записи сверху
    const reversedHistory = Array.from(measurementsHistory.children).reverse();
    measurementsHistory.innerHTML = '';
    reversedHistory.forEach((child) => measurementsHistory.appendChild(child));
}


async function loadMeasurementsFromServer() {
    try {
        const response = await fetch('/getMeasurements');
        if (response.ok) {
            measurementsData = await response.json();

            // Вызываем рендер с отсортированными данными
            renderMeasurementsHistory();
        } else {
          showModal('Ошибка при загрузке замеров с сервера.');
        }
    } catch (error) {
      showModal('Ошибка сети при загрузке данных. Проверьте подключение к интернету.');
    }
}


async function loadUserDataFromServer() {
    try {
        const response = await fetch('/getUserProfile');
        if (response.ok) {
            userData = await response.json();
        } else {
          showModal('Ошибка при загрузке данных пользователя.');
        }
    } catch (error) {
      showModal('Ошибка сети:', error);
    }
}

async function init() {
    await loadUserDataFromServer();
    await loadMeasurementsFromServer();
}

init();

});