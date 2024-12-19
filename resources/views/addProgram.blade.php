<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Создать программу</title>
    <link rel="stylesheet" href="{{ asset('css/addProgram.css') }}">
    <style>
        @font-face {
            font-family: 'INTRO';
            src: url('{{ asset('fonts/INTRO.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
    </style>
</head>
<body>
    <!-- Верхняя панель -->
    <div class="top-bar">
        <button id="cancelButton" class="icon-button">
            <img src="{{ asset('images/icons/close.png') }}" alt="Отмена">
        </button>
        <div id="pageTitle">ПРОГРАММА</div>
        <button id="finishButton" class="icon-button">
            <img src="{{ asset('images/icons/check.png') }}" alt="Завершить">
        </button>
    </div>
    <hr class="separator">

    <!-- Контейнер для названия, опыта и сетов -->
    <div class="program-header">
        <div class="program-stats-left">
            <div class="stats-label">ОПЫТ</div>
            <div id="totalXP" class="stats-value-green">0 XP</div>
        </div>
        <div class="program-name-container">
            <input type="text" id="programName" class="program-name" placeholder="ВЕДИТЕ НАЗВАНИЕ...">
        </div>
        <div class="program-stats-right">
            <div class="stats-label">СЕТЫ</div>
            <div id="totalSets" class="stats-value-gray">0</div>
        </div>
    </div>
    <hr class="separator">

    <!-- Список упражнений -->
    <div id="exercisesContainer">
        <!-- Упражнения добавляются динамически -->
    </div>

    <!-- Кнопка Добавить упражнение -->
    <div class="add-exercise-button-container">
        <!-- Переход на addExercise.html с параметром возврата -->
        <button id="addExerciseButton" class="add-exercise-button"> ДОБАВИТЬ УПРАЖНЕНИЕ</button>
    </div>

    <!-- Модальное окно подтверждения отмены -->
    <div id="cancelModal" class="modal">
        <div class="modal-content">
            <p>ВЫ ТОЧНО ХОТИТЕ ОТМЕНИТЬ СОЗДАНИЕ ПРОГРАММЫ?</p>
            <div class="modal-buttons">
                <button id="confirmCancel" class="confirm-button">Да</button>
                <button id="cancelCancel" class="cancel-button">Отмена</button>
            </div>
        </div>
    </div>

    <!-- Модальное окно подтверждения завершения -->
    <div id="finishModal" class="modal">
        <div class="modal-content">
            <p>ВЫ ТОЧНО ЗАКОНЧИЛИ СОЗДАНИЕ ПРОГРАММЫ?</p>
            <div class="modal-buttons">
                <button id="confirmFinish" class="confirm-button">Да</button>
                <button id="cancelFinish" class="cancel-button">Отмена</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/addProgram.js') }}"></script>
</body>
</html>
