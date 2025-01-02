<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\AuthController;

// Маршруты для замеров
Route::middleware('auth')->group(function () {
    Route::post('/addMeasurement', [MeasurementController::class, 'addMeasurement']);
    Route::get('/getMeasurements', [MeasurementController::class, 'getMeasurements']);
    Route::post('/measurements/add', [MeasurementController::class, 'addMeasurement']);
    Route::get('/measurements', [MeasurementController::class, 'getMeasurements']);
});

// Маршруты для программ
Route::middleware('auth')->group(function () {
    Route::post('/addProgram', [ProgramController::class, 'addProgram']);
    Route::get('/getPrograms', [ProgramController::class, 'getPrograms']);
    Route::post('/deleteProgram', [ProgramController::class, 'deleteProgram']);
    Route::get('/programs', [ProgramController::class, 'getPrograms']);
    Route::get('/program', [ProgramController::class, 'getProgram']);
    Route::post('/program/add', [ProgramController::class, 'addProgram']);
    Route::post('/program/update', [ProgramController::class, 'updateProgram']);
    Route::delete('/program/delete', [ProgramController::class, 'deleteProgram']);
    Route::get('/program/list', [ProgramController::class, 'listPrograms'])->middleware('auth');
    Route::get('/program/list', [WorkoutController::class, 'listPrograms']);
});

// Маршруты профиля пользователя
Route::middleware('auth')->group(function () {
    Route::get('/getUserProfile', [UserController::class, 'getUserProfile']);
    Route::post('/updateProfile', [UserController::class, 'updateProfile'])->middleware('auth');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'getUserProfile'])->name('profile');
    Route::post('/user/profile/update', [UserController::class, 'updateProfile']);
});

// Маршруты тренировок и упражнений
Route::middleware('auth')->group(function () {
    Route::get('/getExercises', [ExerciseController::class, 'getExercises']);
    Route::get('/getRecentExercises', [ExerciseController::class, 'getRecentExercises']);
    Route::post('/addWorkout', [WorkoutController::class, 'addWorkout'])
    ->middleware('web');
    Route::get('/getWorkouts', [WorkoutController::class, 'getWorkouts']);
    Route::get('/getWorkout', [WorkoutController::class, 'getWorkout'])->name('getWorkout');
    Route::get('/exerciseHistory', [WorkoutController::class, 'getExerciseHistory']);
    Route::get('/getExerciseNotes', [WorkoutController::class, 'getExerciseNotes']);
    Route::post('/startProgramWorkout', [WorkoutController::class, 'startProgramWorkout']);
    Route::post('/workout/add', [WorkoutController::class, 'addWorkout']);
    Route::get('/workouts', [WorkoutController::class, 'getWorkouts']);
    Route::get('/workout', [WorkoutController::class, 'getWorkout']);
    Route::get('/exercise/history', [WorkoutController::class, 'getExerciseHistory']);
    Route::get('/lastExerciseSets', [WorkoutController::class, 'getLastExerciseSets']);
    Route::get('/exercise/last-sets', [WorkoutController::class, 'getLastExerciseSets']);
    Route::get('/workout/exercise-notes', [WorkoutController::class, 'getExerciseNotes']);
    Route::post('/workout/start-program', [WorkoutController::class, 'startProgramWorkout']);
    Route::post('/workout/update', [WorkoutController::class, 'updateWorkout']);
    Route::delete('/workout/delete', [WorkoutController::class, 'deleteWorkout']);
    
});

// Маршруты без авторизации
Route::get('/exerciseInfo', [ExerciseController::class, 'getExerciseInfo']);
Route::get('/exercises', [ExerciseController::class, 'getExercises']);
Route::get('/exercises/recent', [ExerciseController::class, 'getRecentExercises']);
Route::get('/exercise/info', [ExerciseController::class, 'getExerciseInfo']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/shop', function () {
    return view('shop');
})->name('shop');

Route::get('/training', function () {
    return view('training');
})->name('training');

Route::get('/workout/history', function () {
    return view('workout_history');
})->name('workout.history');

Route::get('/workout', function () {
    return view('workout');
})->name('workout');

Route::get('/workouts', function () {
    return view('workouts');
})->name('workouts');

Route::get('/exercise', function () {
    return view('exercise');
})->name('exercise');

Route::get('/exercises', function () {
    return view('exercises');
})->name('exercises');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/measurements', function () {
    return view('measurements');
})->name('measurements');

Route::get('/workout_detail', function () {
    return view('workout_detail');
})->name('workout_detail');

Route::get('/profile_settings', function () {
    return view('profile_settings');
})->name('profile_settings');

Route::get('/addProgram', function () {
    return view('addProgram');
})->name('addProgram');

Route::get('/addExercise', function () {
    return view('addExercise');
})->name('addExercise');