<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\WorkoutController;

// Маршруты аутентификации (аналог authRoutes.js)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Маршруты для замеров (аналог measurementRoutes.js)
// Здесь мы используем middleware('authcheck') для защиты маршрутов
Route::middleware('authcheck')->group(function() {
    Route::post('/addMeasurement', [MeasurementController::class, 'addMeasurement']);
    Route::get('/getMeasurements', [MeasurementController::class, 'getMeasurements']);
});

// Маршруты для программ (аналог programRoutes.js)
Route::middleware('authcheck')->group(function() {
    Route::post('/addProgram', [ProgramController::class, 'addProgram']);
    Route::get('/getPrograms', [ProgramController::class, 'getPrograms']);
    Route::post('/deleteProgram', [ProgramController::class, 'deleteProgram']);
});

// Маршруты профиля пользователя (аналог userRoutes.js)
Route::middleware('authcheck')->group(function() {
    Route::get('/getUserProfile', [UserController::class, 'getUserProfile']);
    Route::post('/updateProfile', [UserController::class, 'updateProfile']);
});

// Маршруты тренировок и упражнений (аналог workoutRoutes.js)
// В вашем Node коде часть логики была связана с упражнениями и тренировками.
// Предположим, ExerciseController отвечает за упражнения, WorkoutController — за тренировки.
// Некоторые маршруты доступны без авторизации, другие — с ней. Подумайте, что вам нужно.
// В исходном коде большинство маршрутов защищены, кроме exerciseInfo.  
// Перенесём так же:

// Для упражнений и тренировок
Route::middleware('authcheck')->group(function() {
    Route::get('/getExercises', [ExerciseController::class, 'getExercises']);
    Route::get('/getRecentExercises', [ExerciseController::class, 'getRecentExercises']);
    Route::post('/addWorkout', [WorkoutController::class, 'addWorkout']);
    Route::get('/getWorkouts', [WorkoutController::class, 'getWorkouts']);
    Route::get('/getWorkout', [WorkoutController::class, 'getWorkout']);
    Route::get('/exerciseHistory', [WorkoutController::class, 'getExerciseHistory']);
    Route::get('/getExerciseNotes', [WorkoutController::class, 'getExerciseNotes']);
    Route::post('/startProgramWorkout', [WorkoutController::class, 'startProgramWorkout']);
});

// Маршрут /exerciseInfo в исходном коде не требовал авторизации. Если хотите оставить так же:
Route::get('/exerciseInfo', [ExerciseController::class, 'getExerciseInfo']);

// Тестовый маршрут для Blade-шаблона
Route::get('/test', function () {
    return view('test'); // Laravel будет искать файл resources/views/test.blade.php
});

// Маршрут для страницы профиля
Route::get('/profile', function () {
    return view('profile'); // Laravel будет искать файл resources/views/profile.blade.php
});
