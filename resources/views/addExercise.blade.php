<!-- resources/views/addExercise.blade.php -->

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Добавить упражнение</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite(['resources/css/addExercise.css', 'resources/js/addExercise.js'])
  <link rel="stylesheet" href="{{ asset('css/addExercise.css') }}">
</head>
<body>
  <div class="top-bar">
    <button id="closeButton" class="icon-button">
      <img src="{{ asset('images/icons/close.png') }}" alt="Закрыть">
    </button>
    <div id="pageTitle">ДОБАВИТЬ</div>
  </div>
  <hr class="separator">

  <div class="search-container">
    <div class="search-box">
      <img src="{{ asset('images/icons/search.png') }}" alt="Поиск" class="search-icon">
      <input type="text" id="searchInput" placeholder="ПОИСК УПРАЖНЕНИЯ">
    </div>
    <button id="muscleFilterButton" class="muscle-filter-button">МЫШЦА</button>
    <button id="filterButton" class="filter-button">
      <img src="{{ asset('images/icons/filter.png') }}" alt="Фильтр">
    </button>
  </div>

  <hr class="small-separator">

  <div id="recentExercisesContainer">
    <div class="section-title">ПОСЛЕДНИЕ УПРАЖНЕНИЯ</div>
    <hr class="small-separator">
    <div id="recentExercisesList">
      <!-- Список последних упражнений -->
    </div>
  </div>

  <hr class="small-separator">

  <div id="allExercisesContainer">
    <div class="section-title">ВСЕ УПРАЖНЕНИЯ</div>
    <hr class="small-separator">
    <div id="allExercisesList">
      <!-- Список всех упражнений -->
    </div>
  </div>

  <!-- Модальное окно фильтра мышц -->
  <div id="muscleFilterModal" class="modal">
    <div class="modal-content">
      <div class="modal-title">МЫШЕЧНАЯ ГРУППА</div>
      <hr class="small-separator">

      <!-- Начало списка мышц -->
      @foreach ([
        ['ВСЕ МЫШЦЫ', 'all_muscles.png'],
        ['ГРУДЬ', 'chest.png'],
        ['НОГИ', 'legs.png'],
        ['ПЛЕЧИ', 'shoulders.png'],
        ['СПИНА', 'back.png'],
        ['ЯГОДИЦЫ', 'glutes.png'],
        ['БИЦЕПС', 'biceps.png'],
        ['ПРЕСС', 'abs.png'],
        ['ТРАПЕЦИИ', 'traps.png'],
        ['ИКРЫ', 'calves.png'],
        ['ПОДКОЛЕННЫЕ', 'hamstrings.png'],
        ['ТРИЦЕПС', 'triceps.png'],
        ['ПРЕДПЛЕЧЬЯ', 'forearms.png']
      ] as [$muscle, $image])
        <div class="muscle-option" data-muscle="{{ $muscle }}">
          <img src="{{ asset('images/muscles/' . $image) }}" alt="{{ $muscle }}" class="muscle-icon">
          <span class="muscle-name">{{ $muscle }}</span>
          <span class="muscle-check"></span>
        </div>
        <hr class="very-small-separator">
      @endforeach
    </div>
  </div>

  <!-- Модальное окно фильтрации -->
  <div id="filterModal" class="modal">
    <div class="modal-content">
      <div class="modal-title">ФИЛЬТР</div>
      <hr class="small-separator">
      <div class="filter-option" data-filter="alphabetical">
        <img src="{{ asset('images/icons/alphabetical.png') }}" alt="По алфавиту" class="filter-icon">
        <span class="filter-name">ПО АЛФАВИТУ</span>
        <span class="filter-check"></span>
      </div>
      <hr class="very-small-separator">
      <div class="filter-option" data-filter="level">
        <img src="{{ asset('images/icons/level.png') }}" alt="По уровню" class="filter-icon">
        <span class="filter-name">ПО УРОВНЮ</span>
        <span class="filter-check"></span>
      </div>
    </div>
  </div>

  <script src="{{ asset('js/addExercise.js') }}"></script>
</body>
</html>
