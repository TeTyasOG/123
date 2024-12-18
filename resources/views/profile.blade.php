@extends('layout')

@section('title', 'Профиль')

@section('content')
  <!-- Верхняя панель с кнопками -->
  <div class="top-bar">
    <button id="logoutButton" class="icon-button">
      <img src="{{ asset('images/icons/door.png') }}" alt="Выйти">
    </button>
    <h1 id="userNickname">Никнейм</h1>
    <button id="settingsButton" class="icon-button">
      <img src="{{ asset('images/icons/gear.png') }}" alt="Настройки">
    </button>
  </div>

  <div class="screens-wrapper">
    <button class="icon-button arrow-left">
      <img src="{{ asset('images/icons/back.png') }}" alt="Назад">
    </button>
    <button class="icon-button arrow-right">
      <img src="{{ asset('images/icons/next.png') }}" alt="Вперед">
    </button>
    <div class="screens-container">
      <div class="screen left-screen"></div>
      <div class="screen center-screen">
        <div class="center-content">
          <div class="main-level-container">
            <div class="progress-container">
              <div class="progress-circle">
                <span id="userLevel">1</span>
                <canvas id="progressCanvas" width="200" height="200"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="screen right-screen"></div>
    </div>
  </div>

  <div class="buttons">
    <button id="workoutHistoryButton" class="text-button">ИСТОРИЯ ТРЕНИРОВОК</button>
    <div id="levelProgressContainer" class="level-progress-container">
      <p id="levelProgressText">99%</p>
    </div>
    <button id="measurementsButton" class="text-button">ЗАМЕРЫ</button>
  </div>

  <div class="achievements-container">
    <h2 class="section-title">ДОСТИЖЕНИЯ</h2>
    <p class="empty-text">ПОКА ТУТ ПУСТО</p>
  </div>

  <nav class="bottom-nav">
    <a href="/shop" class="nav-link">
      <img src="{{ asset('images/icons/shop.png') }}" alt="Магазин">
      <span>МАГАЗИН</span>
    </a>
    <a href="/training" class="nav-link">
      <img src="{{ asset('images/icons/training.png') }}" alt="Тренировка">
      <span>ТРЕНИРОВКА</span>
    </a>
    <a href="/profile" class="nav-link active">
      <img src="{{ asset('images/icons/profile.png') }}" alt="Профиль">
      <span>ПРОФИЛЬ</span>
    </a>
  </nav>
@endsection

<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<script src="{{ asset('js/profile.js') }}"></script>

