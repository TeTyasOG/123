<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Measurement;
use App\Models\User;

class MeasurementController extends Controller
{
    // Добавление нового замера
    public function addMeasurement(Request $request)
    {
        try {
            // Получаем userId из сессии
            $userId = $request->session()->get('userId');

            // Валидация входных данных
            $validated = $request->validate([
                'date' => 'required|date',
                'measurements' => 'required|array|min:1'
            ]);

            // Создание нового замера
            $newMeasurement = new Measurement();
            $newMeasurement->user_id = $userId;
            $newMeasurement->date = $validated['date'];
            $newMeasurement->measurements = $validated['measurements'];
            $newMeasurement->save();

            // Если указан вес тела, обновляем вес пользователя
            if (isset($validated['measurements']['Масса тела (кг)'])) {
                User::where('id', $userId)->update([
                    'weight' => $validated['measurements']['Масса тела (кг)']
                ]);
            }

            return response()->json(['message' => 'Замер успешно добавлен.'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Некорректные данные замера.', 'errors' => $e->errors()], 400);
        } catch (\Exception $e) {
            \Log::error('Ошибка при добавлении замера: ' . $e->getMessage());
            return response()->json(['message' => 'Ошибка сервера при добавлении замера.'], 500);
        }
    }

    // Получение истории замеров
    public function getMeasurements(Request $request)
    {
        try {
            // Получаем userId из сессии
            $userId = $request->session()->get('userId');

            // Получаем замеры из базы данных
            $measurements = Measurement::where('user_id', $userId)
                ->orderBy('date', 'desc')
                ->get();

            return response()->json($measurements, 200);
        } catch (\Exception $e) {
            \Log::error('Ошибка при получении замеров: ' . $e->getMessage());
            return response()->json(['message' => 'Ошибка сервера при получении замеров.'], 500);
        }
    }
}
