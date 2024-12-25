<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exercise;
use App\Models\MusclePercentage;
use App\Models\MuscleFilter;
use App\Models\Tip;

class ExerciseSeeder extends Seeder
{
    public function run()
    {
        // Упражнение 1: Barbell Curl
        $barbellCurl = Exercise::create([
            'name' => 'Сгибание рук со штангой',
            'video_url' => '/video/exercises/Barbell_Curl.mp4',
            'thumbnail_url' => '/images/thumbnail/Barbell_Curl.jpg',
            'min_weight_male' => 20,
            'max_weight_male' => 80,
            'min_weight_female' => 10,
            'max_weight_female' => 35,
            'description' => 'Сгибание рук со штангой — базовое упражнение для развития бицепсов, которое выполняется с прямым или изогнутым грифом. Оно помогает увеличить объем и силу рук.',
        ]);

        // Связь с мышцами
        $biceps = MusclePercentage::where('name', 'Руки')->first();
        if ($biceps) {
            $barbellCurl->muscles()->attach($biceps->id, ['percentages' => 100]);
        }

        // Связь с фильтрами
        $filters = ['Бицепс', 'Предплечья'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $barbellCurl->muscleFilters()->attach($filter->id);
            }
        }

        // Добавление советов
        $tips = [
            'Держите спину ровной и избегайте раскачивания корпуса.',
            'Опускайте штангу медленно, контролируя движение.',
            'Не блокируйте локти в нижней точке.'
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $barbellCurl->tips()->attach($tip->id);
        }

        // Упражнение 2: Cable Kneeling Crunch
        $cableCrunch = Exercise::create([
            'name' => 'Скручивания на коленях с тросом',
            'video_url' => '/video/exercises/Cable_Kneeling_Crunch.mp4',
            'thumbnail_url' => '/images/thumbnail/Cable_Kneeling_Crunch.jpg',
            'min_weight_male' => 10,
            'max_weight_male' => 80,
            'min_weight_female' => 5,
            'max_weight_female' => 40,
            'description' => 'Скручивания на коленях с тросом — это эффективное упражнение для проработки верхней и средней части пресса, при котором используется верхний блок. Данная вариация позволяет усилить нагрузку на пресс за счет натяжения троса на протяжении всего движения.',
        ]);

        // Связь с мышцами
        $abs = MusclePercentage::where('name', 'Пресс')->first();
        if ($abs) {
            $cableCrunch->muscles()->attach($abs->id, ['percentages' => 100]);
        }

        // Связь с фильтрами
        $filters = ['Пресс', 'Трапеции'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $cableCrunch->muscleFilters()->attach($filter->id);
            }
        }

        // Добавление советов
        $tips = [
            'Держите корпус стабилизированным, избегайте лишнего движения в пояснице.',
            'Используйте технику скручивания, а не просто сгибания корпуса.',
            'Сосредотачивайтесь на напряжении пресса, не создавая напряжения в шее или спине.',
            'Плавно возвращайтесь в исходное положение, не расслабляя мышцы пресса.'
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $cableCrunch->tips()->attach($tip->id);
        }
    }
}
