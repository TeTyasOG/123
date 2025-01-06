<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Measurement;
use App\Models\MeasurementUnit;
use App\Models\UnitMeasurement;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MeasurementController extends Controller
{
    // Добавление нового замера
    public function addMeasurement(Request $request)
    {
        try {
            // Проверяем, авторизован ли пользователь
            $userId = Auth::id();
            if (!$userId) {
                return response()->json(['message' => 'Пользователь не авторизован.'], 401);
            }

            // Валидация входных данных
            $validated = $request->validate([
                'date' => 'required|date',
                'measurements' => 'required|array|min:1',
            ]);

            DB::beginTransaction();

            // Создаём запись в таблице measurements
            $newMeasurement = new Measurement();
            $newMeasurement->user_id = $userId;
            $newMeasurement->date = $validated['date'];
            $newMeasurement->save(); // теперь имеем ID

            // Готовим данные для pivot-таблицы measurement_unit
            $measurementUnitsData = [];

            foreach ($validated['measurements'] as $name => $value) {
                // Ищем запись в справочнике unit_measurements
                $unitMeasurement = UnitMeasurement::where('name', $name)->first();

                // Если не нашли, пропускаем (или можно создать, если требуется)
                if (!$unitMeasurement) {
                    continue;
                }

                $measurementUnitsData[] = [
                    'unit_measurement_id' => $unitMeasurement->id,
                    'value'               => $value,
                    'created_at'          => now(),
                    'updated_at'          => now(),
                ];
            }

            // Создаём записи в measurement_unit
            $newMeasurement->measurementUnits()->createMany($measurementUnitsData);

            // Дополнительно, если есть «Масса тела (кг)», обновим поле weight у пользователя
            if (isset($validated['measurements']['Масса тела (кг)'])) {
                User::where('id', $userId)->update([
                    'weight' => $validated['measurements']['Масса тела (кг)']
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'Замер успешно добавлен.'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Некорректные данные замера.',
                'errors' => $e->errors()
            ], 400);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ошибка сервера при добавлении замера.'], 500);
        }
    }

    // Получение истории замеров
    public function getMeasurements(Request $request)
    {
        try {
            // Проверяем, авторизован ли пользователь
            $userId = Auth::id();
            if (!$userId) {
                return response()->json(['message' => 'Пользователь не авторизован.'], 401);
            }
    
            // Получаем замеры с подгруженными значениями (pivot-таблица + названия из unit_measurements)
            $measurements = Measurement::where('user_id', $userId)
                ->with(['measurementUnits.unitMeasurement']) 
                ->orderBy('date', 'desc')
                ->get();
    
            // Преобразуем структуру
            $transformed = $measurements->map(function ($measurement) {
    
                $params = [];
                foreach ($measurement->measurementUnits as $mu) {
                    if ($mu->unitMeasurement) {
                        $params[$mu->unitMeasurement->name] = $mu->value;
                    }
                }
    
                return [
                    'id'           => $measurement->id, // Добавляем id
                    'date'         => $measurement->date->format('Y-m-d'),
                    'measurements' => $params,
                ];
            });
            return response()->json($transformed, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ошибка сервера при получении замеров.'], 500);
        }
    }
    
}
