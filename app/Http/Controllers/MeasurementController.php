<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use App\Models\User;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    public function addMeasurement(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'measurements' => 'required|array'
        ]);

        $userId = $request->session()->get('userId');
        if (!$userId) {
            return response()->json(['message' => 'Требуется авторизация.'], 401);
        }

        $newMeasurement = Measurement::create([
            'userId' => $userId,
            'date' => $request->date,
            'measurements' => $request->measurements
        ]);

        // Если указан вес тела
        if (isset($request->measurements['Масса тела (кг)'])) {
            User::where('_id', $userId)->update(['weight' => $request->measurements['Масса тела (кг)']]);
        }

        return response()->json(['message' => 'Замер успешно добавлен.'], 200);
    }

    public function getMeasurements(Request $request)
    {
        $userId = $request->session()->get('userId');
        if (!$userId) {
            return response()->json(['message' => 'Требуется авторизация.'], 401);
        }

        $measurements = Measurement::where('userId', $userId)->orderBy('date', 'desc')->get();

        return response()->json($measurements);
    }
}
