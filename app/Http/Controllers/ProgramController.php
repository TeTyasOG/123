<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    // Добавление новой программы
    public function addProgram(Request $request)
    {
        try {
            $userId = session('userId');
            $name = $request->input('name');
            $exercises = $request->input('exercises');

            // Проверка обязательных полей
            if (!$name || !$exercises || count($exercises) === 0) {
                return response()->json(['message' => 'Пожалуйста, заполните все поля.'], 400);
            }

            // Создание новой программы
            $program = new Program([
                'user_id' => $userId,
                'name' => $name,
                'exercises' => $exercises,
            ]);
            $program->save();

            return response()->json(['message' => 'Программа успешно сохранена.']);
        } catch (\Exception $e) {
            \Log::error('Ошибка при добавлении программы: ' . $e->getMessage());
            return response()->json(['message' => 'Ошибка при добавлении программы.'], 500);
        }
    }

    // Получение программ пользователя
    public function getPrograms(Request $request)
    {
        try {
            $userId = session('userId');
            $search = $request->query('search');

            $query = Program::where('user_id', $userId);

            if ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%');
            }

            // Подгрузка данных об упражнениях
            $programs = $query->with('exercises')->get();

            return response()->json($programs);
        } catch (\Exception $e) {
            \Log::error('Ошибка при получении программ: ' . $e->getMessage());
            return response()->json(['message' => 'Ошибка при получении программ.'], 500);
        }
    }

    // Удаление программы
    public function deleteProgram(Request $request)
    {
        try {
            $userId = session('userId');
            $programId = $request->input('programId');

            $program = Program::where('id', $programId)
                ->where('user_id', $userId)
                ->first();

            if (!$program) {
                return response()->json(['message' => 'Программа не найдена.'], 404);
            }

            $program->delete();

            return response()->json(['message' => 'Программа успешно удалена.']);
        } catch (\Exception $e) {
            \Log::error('Ошибка при удалении программы: ' . $e->getMessage());
            return response()->json(['message' => 'Ошибка при удалении программы.'], 500);
        }
    }
}
