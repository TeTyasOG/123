<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function addProgram(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'exercises' => 'required|array|min:1'
        ]);

        $userId = $request->session()->get('userId');
        if (!$userId) {
            return response()->json(['message' => 'Требуется авторизация.'], 401);
        }

        Program::create([
            'userId' => $userId,
            'name' => $request->name,
            'exercises' => $request->exercises
        ]);

        return response()->json(['message' => 'Программа успешно сохранена.']);
    }

    public function getPrograms(Request $request)
    {
        $userId = $request->session()->get('userId');
        if (!$userId) {
            return response()->json(['message' => 'Требуется авторизация.'], 401);
        }

        $search = $request->query('search');

        $query = Program::where('userId', $userId);
        if ($search) {
            $query->where('name', 'regexp', $search, 'i');
        }

        // Если нужно подгрузить упражнения, предполагается, что exercises - массив объектов {exerciseId, sets, reps}.
        // Отношения не заданы, можно вручную получить exerciseId и подгрузить данные при необходимости.
        // Ниже - простой пример без "populate" (в MongoDB через Eloquent нет прямого populate как в Mongoose):
        // Можно вручную получить exerciseId и собрать данные. Здесь оставим упрощенный вариант.

        $programs = $query->get();

        return response()->json($programs);
    }

    public function deleteProgram(Request $request)
    {
        $request->validate([
            'programId' => 'required|string'
        ]);

        $userId = $request->session()->get('userId');
        if (!$userId) {
            return response()->json(['message' => 'Требуется авторизация.'], 401);
        }

        Program::where('_id', $request->programId)->where('userId', $userId)->delete();

        return response()->json(['message' => 'Программа успешно удалена.']);
    }
}
