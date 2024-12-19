// exercises.js

document.addEventListener('DOMContentLoaded', () => {
    const filterForm = document.getElementById('filterForm');
    const muscleGroupSelect = document.getElementById('muscleGroup');
    const exerciseListDiv = document.getElementById('exerciseList');

    // Функция для загрузки упражнений с сервера
    async function loadExercises(muscleGroup = '') {
        try {
            const response = await fetch('/getExercises?muscleGroup=' + muscleGroup);
            if (response.ok) {
                const exercises = await response.json();
                displayExercises(exercises);
            } else {
                console.error('Ошибка при загрузке упражнений.');
            }
        } catch (error) {
            console.error('Ошибка:', error);
        }
    }

    // Функция для отображения упражнений на странице
    function displayExercises(exercises) {
        exerciseListDiv.innerHTML = '';

        if (exercises.length === 0) {
            exerciseListDiv.textContent = 'Упражнения не найдены.';
            return;
        }

        exercises.forEach(exercise => {
            const card = document.createElement('div');
            card.className = 'exercise-card';

            const title = document.createElement('h3');
            title.textContent = exercise.name;

            const video = document.createElement('video');
            video.controls = true;
            video.src = exercise.videoUrl;

            const muscles = document.createElement('p');
            muscles.textContent = 'Задействованные мышцы: ' + exercise.muscles.join(', ');

            card.appendChild(title);
            card.appendChild(video);
            card.appendChild(muscles);

            exerciseListDiv.appendChild(card);
        });
    }

    // Обработчик отправки формы фильтрации
    filterForm.addEventListener('submit', (event) => {
        event.preventDefault();
        const selectedMuscleGroup = muscleGroupSelect.value;
        loadExercises(selectedMuscleGroup);
    });

    // Загрузка всех упражнений при загрузке страницы
    loadExercises();
});
