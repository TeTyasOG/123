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
                    $barbellCurl->musclePercentages()->attach($biceps->id, ['percentages' => 100]);
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
        
        // Упражнение 1: Dumbbell Curl
        $dumbbellCurl = Exercise::create([
            'name' => 'Сгибание рук с гантелями',
            'video_url' => '/video/exercises/Dumbbell_Curl.mp4',
            'thumbnail_url' => '/images/thumbnail/Dumbbell_Curl.jpg',
            'min_weight_male' => 5,
            'max_weight_male' => 30,
            'min_weight_female' => 3,
            'max_weight_female' => 15,
            'description' => 'Сгибание рук с гантелями — одно из самых популярных упражнений для проработки бицепсов, позволяющее выполнять движение по индивидуальной амплитуде. Используется как в изолированной форме, так и в сочетании с другими упражнениями.',
        ]);
        
        // Связь с мышцами
        $biceps = MusclePercentage::where('name', 'Руки')->first();
        if ($biceps) {
            $dumbbellCurl->musclePercentages()->attach($biceps->id, ['percentages' => 100]);
        }
        
        // Связь с фильтрами
        $filters = ['Бицепс', 'Предплечья'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $dumbbellCurl->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Следите за стабильностью корпуса и избегайте раскачивания.',
            'Поднимайте гантели одновременно или поочередно, контролируя каждую фазу движения.',
            'Не перегружайте локти и кисти, держите их в естественном положении.'
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $dumbbellCurl->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Preacher Curl
        $preacherCurl = Exercise::create([
            'name' => 'Сгибание рук на скамье Скотта',
            'video_url' => '/video/exercises/Preacher_Curl.mp4',
            'thumbnail_url' => '/images/thumbnail/Preacher_Curl.jpg',
            'min_weight_male' => 15,
            'max_weight_male' => 50,
            'min_weight_female' => 5,
            'max_weight_female' => 25,
            'description' => 'Сгибание рук на скамье Скотта — изолированное упражнение для бицепсов, которое исключает возможность читинга за счет фиксированного положения рук. Отлично подходит для формирования пиковой формы бицепса и проработки нижней части мышцы.',
        ]);
        
        if ($biceps) {
            $preacherCurl->musclePercentages()->attach($biceps->id, ['percentages' => 100]);
        }
        
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $preacherCurl->muscleFilters()->attach($filter->id);
            }
        }
        
        $tips = [
            'Плотно прижимайте руки к скамье для предотвращения читинга.',
            'Используйте контролируемое движение, избегая рывков.',
            'Держите локти в неподвижном положении на протяжении всего упражнения.',
            'Начинайте с небольшого веса для освоения техники.'
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $preacherCurl->tips()->attach($tip->id);
        }
        
        // Упражнение 3: Dumbbell Hammer Curl
        $dumbbellHammerCurl = Exercise::create([
            'name' => 'Сгибание рук с гантелями "молотком"',
            'video_url' => '/video/exercises/Dumbbell_Hammer_Curl.mp4',
            'thumbnail_url' => '/images/thumbnail/Dumbbell_Hammer_Curl.jpg',
            'min_weight_male' => 5,
            'max_weight_male' => 30,
            'min_weight_female' => 3,
            'max_weight_female' => 15,
            'description' => 'Сгибание рук с гантелями "молотком" отличается нейтральным хватом, что равномерно распределяет нагрузку между бицепсами и предплечьями. Это упражнение способствует укреплению плечевой мышцы и увеличению толщины рук.',
        ]);
        
        $dumbbellHammerCurl->musclePercentages()->attach($biceps->id, ['percentages' => 90]);
        $shoulders = MusclePercentage::where('name', 'Плечи')->first();
        if ($shoulders) {
            $dumbbellHammerCurl->musclePercentages()->attach($shoulders->id, ['percentages' => 10]);
        }
        
        $filters = ['Бицепс', 'Предплечья', 'Плечи'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $dumbbellHammerCurl->muscleFilters()->attach($filter->id);
            }
        }
        
        $tips = [
            'Держите локти прижатыми к туловищу, избегая их смещения.',
            'Контролируйте движение на всем протяжении, особенно в нижней фазе.',
            'Избегайте раскачивания корпуса, чтобы не снижать эффективность упражнения.',
            'Выполняйте упражнение как обеими руками одновременно, так и поочередно, чтобы лучше проработать каждую руку.'
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $dumbbellHammerCurl->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Cable High to Low Woodchopper
        $cableWoodchopper = Exercise::create([
            'name' => 'Повороты с тросом сверху вниз',
            'video_url' => '/video/exercises/Cable_High_to_Low_Woodchopper.mp4',
            'thumbnail_url' => '/images/thumbnail/Cable_High_to_Low_Woodchopper.jpg',
            'min_weight_male' => 10,
            'max_weight_male' => 40,
            'min_weight_female' => 5,
            'max_weight_female' => 20,
            'description' => 'Повороты с тросом сверху вниз — это функциональное упражнение, которое помогает проработать как пресс, так и косые мышцы живота. Оно имитирует движения, используемые в спортивных и повседневных активностях, таких как резкие повороты и скручивания тела. Работает на стабильность корпуса и улучшение силы в области туловища.',
        ]);
        
        // Связь с мышцами
        $coreMuscle = MusclePercentage::where('name', 'Пресс')->first();
        if ($coreMuscle) {
            $cableWoodchopper->musclePercentages()->attach($coreMuscle->id, ['percentages' => 100]);
        }
        
        // Связь с фильтрами
        $filters = ['Пресс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $cableWoodchopper->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Начинайте движение с плеч, а не с рук, чтобы активировать мышцы кора.',
            'Держите ноги слегка согнутыми, а корпус немного наклонённым, чтобы стабилизировать тело.',
            'Важно выполнять движение через полную амплитуду и избегать резких рывков.',
            'Контролируйте как подъем, так и опускание для эффективной работы мышц.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $cableWoodchopper->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Cable Standing Crunch
        $cableStandingCrunch = Exercise::create([
            'name' => 'Скручивания на блоке в стойке',
            'video_url' => '/video/exercises/Cable_Standing_Crunch.mp4',
            'thumbnail_url' => '/images/thumbnail/Cable_Standing_Crunch.jpg',
            'min_weight_male' => 10,
            'max_weight_male' => 50,
            'min_weight_female' => 5,
            'max_weight_female' => 25,
            'description' => 'Скручивания на блоке в стойке — это упражнение для проработки верхней и средней части пресса, выполняемое стоя с использованием блока. Это движение помогает изолировать пресс, одновременно активируя стабилизаторы корпуса и снижая нагрузку на спину.',
        ]);
        
        // Связь с мышцами
        $abs = MusclePercentage::where('name', 'Пресс')->first();
        if ($abs) {
            $cableStandingCrunch->musclePercentages()->attach($abs->id, ['percentages' => 100]);
        }
        
        // Связь с фильтрами
        $filters = ['Пресс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $cableStandingCrunch->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Держите ноги на ширине плеч, колени немного согнуты для стабильности.',
            'Выполняйте скручивание, направляя локти вниз, а не просто сгибая корпус.',
            'Используйте медленный и контролируемый темп, чтобы повысить напряжение в прессе.',
            'Убедитесь, что в движении участвует только пресс, избегая чрезмерного напряжения в спине или шее.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $cableStandingCrunch->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Cable Pulldown
        $cablePulldown = Exercise::create([
            'name' => 'Тяга верхнего блока',
            'video_url' => '/video/exercises/Cable_Pulldown.mp4',
            'thumbnail_url' => '/images/thumbnail/Cable_Pulldown.jpg',
            'min_weight_male' => 20,
            'max_weight_male' => 80,
            'min_weight_female' => 10,
            'max_weight_female' => 35,
            'description' => 'Тяга верхнего блока — одно из базовых упражнений для тренировки спины. Основной акцент на широчайшие мышцы, также активно работают бицепсы и трапеции. Это упражнение помогает развить силу и ширину спины.',
        ]);
        
        // Связь с мышцами
        $backMuscle = MusclePercentage::where('name', 'Спина')->first();
        $armMuscle = MusclePercentage::where('name', 'Руки')->first();
        if ($backMuscle) {
            $cablePulldown->musclePercentages()->attach($backMuscle->id, ['percentages' => 85]);
        }
        if ($armMuscle) {
            $cablePulldown->musclePercentages()->attach($armMuscle->id, ['percentages' => 15]);
        }
        
        // Связь с фильтрами
        $filters = ['Широчайшие', 'Бицепс', 'Трапеции'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $cablePulldown->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Тяните рукоять вниз, избегая наклонов тела назад.',
            'Сосредоточьтесь на сокращении мышц спины, а не на использовании рук.',
            'Используйте полный диапазон движения, контролируя как подъем, так и опускание.'
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $cablePulldown->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Barbell Bent Over Row
        $barbellRow = Exercise::create([
            'name' => 'Тяга штанги в наклоне',
            'video_url' => '/video/exercises/Barbell_Bent_Over_Row.mp4',
            'thumbnail_url' => '/images/thumbnail/Barbell_Bent_Over_Row.jpg',
            'min_weight_male' => 20,
            'max_weight_male' => 100,
            'min_weight_female' => 10,
            'max_weight_female' => 40,
            'description' => 'Тяга штанги в наклоне — это мощное упражнение для тренировки спины, которое развивает широчайшие и трапеции, а также помогает укрепить бицепсы. Оно выполняется в наклонной позиции с удержанием штанги на вытянутых руках и подъемом её к животу. Это упражнение улучшает общую силу спины и стабилизацию корпуса.',
        ]);
        
        // Связь с мышцами
        $back = MusclePercentage::where('name', 'Спина')->first();
        if ($back) {
            $barbellRow->musclePercentages()->attach($back->id, ['percentages' => 90]);
        }
        
        $arms = MusclePercentage::where('name', 'Руки')->first();
        if ($arms) {
            $barbellRow->musclePercentages()->attach($arms->id, ['percentages' => 10]);
        }
        
        // Связь с фильтрами
        $filters = ['Широчайшие', 'Трапеции', 'Бицепс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $barbellRow->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Держите спину прямой, избегайте округления поясницы.',
            'Тяните штангу не только руками, но и с помощью работы спины.',
            'Сфокусируйтесь на движении локтей вдоль тела, а не на поднятии штанги за счет рывков.',
            'Важно контролировать амплитуду, не допуская чрезмерных раскачиваний.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $barbellRow->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Dumbbell Bent Over Row
        $dumbbellBentOverRow = Exercise::create([
            'name' => 'Тяга гантелей в наклоне',
            'video_url' => '/video/exercises/Dumbbell_Bent_Over_Row.mp4',
            'thumbnail_url' => '/images/thumbnail/Dumbbell_Bent_Over_Row.jpg',
            'min_weight_male' => 10,
            'max_weight_male' => 40,
            'min_weight_female' => 5,
            'max_weight_female' => 20,
            'description' => 'Тяга гантелей в наклоне — это упражнение, направленное на развитие мышц спины, особенно широчайших и трапеций, с акцентом на контроль и стабилизацию корпуса. Оно выполняется с гантелями в каждой руке, что позволяет улучшить баланс и координацию, а также снижает риск дисбаланса между правой и левой стороной тела.',
        ]);
        
        // Связь с мышцами
        $back = MusclePercentage::where('name', 'Спина')->first();
        if ($back) {
            $dumbbellBentOverRow->musclePercentages()->attach($back->id, ['percentages' => 90]);
        }
        
        $arms = MusclePercentage::where('name', 'Руки')->first();
        if ($arms) {
            $dumbbellBentOverRow->musclePercentages()->attach($arms->id, ['percentages' => 10]);
        }
        
        // Связь с фильтрами
        $filters = ['Широчайшие', 'Трапеции', 'Бицепс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $dumbbellBentOverRow->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Держите спину прямой, избегая округления позвоночника.',
            'Подтягивайте гантели к бедрам, не раскачиваясь и не используя инерцию.',
            'Сфокусируйтесь на движении локтей вдоль тела для активации спины.',
            'Не допускать перенапряжения в плечах — работайте только мышцами спины.'
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $dumbbellBentOverRow->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Cable Seated Row
        $cableSeatedRow = Exercise::create([
            'name' => 'Сидячая тяга блока',
            'video_url' => '/video/exercises/Cable_Seated_Row.mp4',
            'thumbnail_url' => '/images/thumbnail/Cable_Seated_Row.jpg',
            'min_weight_male' => 20,
            'max_weight_male' => 80,
            'min_weight_female' => 10,
            'max_weight_female' => 35,
            'description' => 'Сидячая тяга блока — упражнение, направленное на тренировки спины, с фокусом на широчайшие и трапеции, а также включающее бицепсы. Оно выполняется с использованием троса и сиденья, что помогает обеспечить правильную технику и поддерживать стабилизацию корпуса. Это упражнение способствует укреплению спины и улучшению общей силы верхней части тела.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            'Спина' => 90,
            'Руки' => 10
        ];
        
        foreach ($muscles as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $cableSeatedRow->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Широчайшие', 'Трапеции', 'Бицепс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $cableSeatedRow->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Сидите прямо, не прогибая поясницу.',
            'Тяните рукоять к животу, не используя инерцию, концентрируясь на мышцах спины.',
            'Важно контролировать движение, избегать рывков или чрезмерных напряжений в плечах.',
            'Сохраняйте локти близко к корпусу и не допуская их выпадения в стороны.',
        ];
        
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $cableSeatedRow->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Lever T-bar Row
        $leverTBarRow = Exercise::create([
            'name' => 'Тяга Т-грифа на тренажере',
            'video_url' => '/video/exercises/Lever_T_bar_Row.mp4',
            'thumbnail_url' => '/images/thumbnail/Lever_T_bar_Row.jpg',
            'min_weight_male' => 20,
            'max_weight_male' => 100,
            'min_weight_female' => 10,
            'max_weight_female' => 40,
            'description' => 'Тяга Т-грифа на тренажере — эффективное упражнение для тренировки спины, особенно для широчайших и трапеций. Это движение выполняется с использованием Т-грифа и специализированного тренажера, который позволяет глубже прорабатывать мышцы спины, с минимальной нагрузкой на поясницу. Это упражнение помогает развить общую силу и толщину спины.',
        ]);
        
        // Связь с мышцами
        $back = MusclePercentage::where('name', 'Спина')->first();
        if ($back) {
            $leverTBarRow->musclePercentages()->attach($back->id, ['percentages' => 95]);
        }
        $arms = MusclePercentage::where('name', 'Руки')->first();
        if ($arms) {
            $leverTBarRow->musclePercentages()->attach($arms->id, ['percentages' => 5]);
        }
        
        // Связь с фильтрами
        $filters = ['Широчайшие', 'Трапеции', 'Бицепс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $leverTBarRow->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Держите спину прямой и избегайте округления поясницы.',
            'Тяните рукоять к нижней части живота, а не слишком высоко, чтобы не перегружать плечи.',
            'Используйте полный диапазон движения, сохраняя контроль на протяжении всего упражнения.',
            'Сфокусируйтесь на работе спины, минимизируя вовлечение бицепсов.'
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $leverTBarRow->tips()->attach($tip->id);
        }
        
        // Упражнение: Lever Seated Reverse Fly
        $leverSeatedReverseFly = Exercise::create([
            'name' => 'Обратные махи на тренажере сидя',
            'video_url' => '/video/exercises/Lever_Seated_Reverse_Fly.mp4',
            'thumbnail_url' => '/images/thumbnail/Lever_Seated_Reverse_Fly.jpg',
            'min_weight_male' => 10,
            'max_weight_male' => 50,
            'min_weight_female' => 5,
            'max_weight_female' => 20,
            'description' => 'Обратные махи на тренажере сидя — это упражнение, направленное на тренировку задних дельт, трапеций и верхней части спины. Оно выполняется на специализированном тренажере, что позволяет минимизировать нагрузку на спину и сосредоточиться на изоляции мышц плеч и спины. Это упражнение помогает улучшить осанку и развить мышечную массу в верхней части спины.',
        ]);
        
        // Связь с мышцами
        $musclePercentages = [
            'Спина' => 90,
            'Плечи' => 10,
        ];
        foreach ($musclePercentages as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $leverSeatedReverseFly->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Широчайшие', 'Трапеции', 'Плечи'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $leverSeatedReverseFly->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Сидите прямо, избегая наклонов тела вперед.',
            'Сконцентрируйтесь на движении плеч, а не рук, для активизации спинных и плечевых мышц.',
            'Используйте полный диапазон движения, чтобы максимально растянуть и сократить мышцы.',
            'Контролируйте движение на всех этапах, избегая рывков и чрезмерной инерции.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $leverSeatedReverseFly->tips()->attach($tip->id);
        }
        
        // Упражнение: Dumbbell Bent Over Twisting Row
        $dumbbellRow = Exercise::create([
            'name' => 'Тяга гантелей в наклоне с поворотом',
            'video_url' => '/video/exercises/Dumbbell_Bent_Over_Twisting_Row.mp4',
            'thumbnail_url' => '/images/thumbnail/Dumbbell_Bent_Over_Twisting_Row.jpg',
            'min_weight_male' => 10,
            'max_weight_male' => 40,
            'min_weight_female' => 5,
            'max_weight_female' => 20,
            'description' => 'Тяга гантелей в наклоне с поворотом — упражнение для спины с добавлением поворота корпуса. Это движение активно включает широчайшие мышцы, трапеции и бицепсы, а также помогает проработать мышцы стабилизаторы. Поворот позволяет активировать косые мышцы живота и задействовать плечи для стабилизации. Это упражнение отлично развивает толщину спины и способствует улучшению силы всего корпуса.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            'Спина' => 85,
            'Руки' => 10,
            'Плечи' => 5,
        ];
        foreach ($muscles as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $dumbbellRow->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Широчайшие', 'Трапеции', 'Бицепс', 'Плечи'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $dumbbellRow->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Держите спину прямой на протяжении всего упражнения, избегайте прогибов в пояснице.',
            'Выполняйте поворот корпуса в конце движения, не используя инерцию.',
            'Сосредоточьтесь на равномерной работе обеих сторон тела, избегая перекоса в сторону.',
            'Поддерживайте стабильность в ногах и корпусе, чтобы избежать чрезмерного напряжения в пояснице.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $dumbbellRow->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Lever Seated Row
        $leverSeatedRow = Exercise::create([
            'name' => 'Сидячая тяга на тренажере',
            'video_url' => '/video/exercises/Lever_Seated_Row.mp4',
            'thumbnail_url' => '/images/thumbnail/Lever_Seated_Row.jpg',
            'min_weight_male' => 20,
            'max_weight_male' => 80,
            'min_weight_female' => 10,
            'max_weight_female' => 35,
            'description' => 'Сидячая тяга на тренажере — это упражнение для тренировки спины, в особенности широчайших мышц и трапеций, с акцентом на изоляцию этих мышц при минимальной нагрузке на поясницу. Оно выполняется сидя с использованием механизма тренажера, что позволяет лучше контролировать амплитуду движения.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            ['name' => 'Спина', 'percentage' => 90],
            ['name' => 'Руки', 'percentage' => 10],
        ];
        foreach ($muscles as $muscleData) {
            $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
            if ($muscle) {
                $leverSeatedRow->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentage']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Широчайшие', 'Трапеции', 'Бицепс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $leverSeatedRow->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Сохраняйте спину прямой, избегайте округления позвоночника.',
            'Тяните рукоятку к животу, контролируя движение и избегая рывков.',
            'Используйте полный диапазон движения для максимальной активации мышц спины.',
            'Убедитесь, что локти двигаются вдоль тела, чтобы снизить нагрузку на плечевые суставы.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $leverSeatedRow->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Cable Wide Pulldown
        $cableWidePulldown = Exercise::create([
            'name' => 'Широкая тяга верхнего блока',
            'video_url' => '/video/exercises/Cable_Wide_Pulldown.mp4',
            'thumbnail_url' => '/images/thumbnail/Cable_Wide_Pulldown.jpg',
            'min_weight_male' => 20,
            'max_weight_male' => 80,
            'min_weight_female' => 10,
            'max_weight_female' => 35,
            'description' => 'Широкая тяга верхнего блока — это базовое упражнение для тренировки спины, с акцентом на широчайшие мышцы. Оно выполняется с использованием троса и широкого хвата, что помогает активно развивать верхнюю и среднюю часть спины. Тяга позволяет улучшить ширину спины, а также задействует бицепсы и трапеции.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            'Спина' => 85,
            'Руки' => 15
        ];
        foreach ($muscles as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $cableWidePulldown->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Широчайшие', 'Бицепс', 'Трапеции'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $cableWidePulldown->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Сидите прямо, не отклоняйтесь назад.',
            'Тяните рукоятку вниз, контролируя движение, избегая рывков.',
            'Фокусируйтесь на том, чтобы локти двигались вдоль тела, а не в стороны.',
            'Держите плечи опущенными, не позволяйте им подниматься вверх.'
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $cableWidePulldown->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Barbell Deadlift
        $barbellDeadlift = Exercise::create([
            'name' => 'Становая тяга со штангой',
            'video_url' => '/video/exercises/Barbell_Deadlift.mp4',
            'thumbnail_url' => '/images/thumbnail/Barbell_Deadlift.jpg',
            'min_weight_male' => 50,
            'max_weight_male' => 250,
            'min_weight_female' => 30,
            'max_weight_female' => 100,
            'description' => 'Становая тяга — одно из самых эффективных упражнений для развития силы всего тела, с фокусом на спину, ягодицы и ноги. Выполняется с прямой спиной, начиная с пола и подъемом штанги до уровня бедер. Это упражнение задействует множество мышц, включая трапеции и заднюю цепь, и является основой для развития общей силы.',
        ]);
        
        // Связь с мышцами
        $musclePercentages = [
            'Ноги' => 60,
            'Спина' => 40,
        ];
        foreach ($musclePercentages as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $barbellDeadlift->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Ягодицы', 'Ноги', 'Спина', 'Трапеции'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $barbellDeadlift->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Держите спину прямой, избегайте округления поясницы, чтобы избежать травм.',
            'Активно используйте ноги для подъема штанги, а не только спину.',
            'Контролируйте движение на всех этапах, начиная с подъема и заканчивая опусканием штанги.',
            'Распределяйте вес равномерно по ногам и ягодицам, избегая напряжения в нижней части спины.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $barbellDeadlift->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Barbell Rack Pull
        $barbellRackPull = Exercise::create([
            'name' => 'Ракетная тяга со штангой',
            'video_url' => '/video/exercises/Barbell_Rack_Pull.mp4',
            'thumbnail_url' => '/images/thumbnail/Barbell_Rack_Pull.jpg',
            'min_weight_male' => 50,
            'max_weight_male' => 220,
            'min_weight_female' => 30,
            'max_weight_female' => 90,
            'description' => 'Ракетная тяга — это упражнение, которое представляет собой разновидность становой тяги, но с частичным диапазоном движения, выполняемое с использованием стойки или бампера. Оно акцентирует нагрузку на верхнюю часть спины, трапеции и заднюю часть бедра, при этом минимизирует нагрузку на нижнюю часть спины. Это упражнение идеально подходит для улучшения силы спины и увеличения рабочей мощности в становой тяге.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            ['name' => 'Спина', 'percentage' => 70],
            ['name' => 'Ноги', 'percentage' => 30],
        ];
        foreach ($muscles as $muscleData) {
            $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
            if ($muscle) {
                $barbellRackPull->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentage']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Спина', 'Ноги', 'Ягодицы', 'Трапеции'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $barbellRackPull->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Поднимайте штангу только с верхней части бедер, избегая чрезмерного прогиба в пояснице.',
            'Сфокусируйтесь на активной работе трапеций и верхней части спины при подъеме штанги.',
            'Держите штангу близко к телу на протяжении всего движения.',
            'Контролируйте опускание штанги, не допускайте резких рывков.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $barbellRackPull->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Smith Shrug
        $smithShrug = Exercise::create([
            'name' => 'Шраг на тренажере Смита',
            'video_url' => '/video/exercises/Smith_Shrug.mp4',
            'thumbnail_url' => '/images/thumbnail/Smith_Shrug.jpg',
            'min_weight_male' => 20,
            'max_weight_male' => 70,
            'min_weight_female' => 10,
            'max_weight_female' => 30,
            'description' => 'Шраг на тренажере Смита — это упражнение, направленное на тренировку трапеций. С использованием тренажера Смита можно стабилизировать штангу и сосредоточиться на подъеме плеч, что позволяет эффективно прорабатывать верхнюю часть спины. Это упражнение помогает развить силу и размер трапеций.',
        ]);
        
        // Связь с мышцами
        $backMuscle = MusclePercentage::where('name', 'Спина')->first();
        if ($backMuscle) {
            $smithShrug->musclePercentages()->attach($backMuscle->id, ['percentages' => 90]);
        }
        $shoulderMuscle = MusclePercentage::where('name', 'Плечи')->first();
        if ($shoulderMuscle) {
            $smithShrug->musclePercentages()->attach($shoulderMuscle->id, ['percentages' => 10]);
        }
        
        // Связь с фильтрами
        $filters = ['Трапеции', 'Плечи'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $smithShrug->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Держите спину прямой и не допускайте наклонов вперед.',
            'Поднимайте плечи вверх, не используя инерцию.',
            'Не используйте слишком тяжелые веса, чтобы избежать напряжения в шее или плечах.',
            'Сконцентрируйтесь на сокращении трапеций в верхней точке, удерживая движение на несколько секунд.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $smithShrug->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Dumbbell Renegade Row
        $dumbbellRenegadeRow = Exercise::create([
            'name' => 'Ренегатная тяга с гантелями',
            'video_url' => '/video/exercises/Dumbbell_Renegade_Row.mp4',
            'thumbnail_url' => '/images/thumbnail/Dumbbell_Renegade_Row.jpg',
            'min_weight_male' => 15,
            'max_weight_male' => 50,
            'min_weight_female' => 8,
            'max_weight_female' => 25,
            'description' => 'Ренегатная тяга с гантелями — это комплексное упражнение, которое сочетает в себе элементы тяги и планки. Оно активно задействует спину, плечи, бицепсы, а также мышцы стабилизаторы, включая пресс. Это упражнение развивает силу и выносливость, а также помогает улучшить баланс и координацию.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            'Спина' => 50,
            'Руки' => 20,
            'Плечи' => 15,
            'Пресс' => 15,
        ];
        foreach ($muscles as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $dumbbellRenegadeRow->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Широчайшие', 'Бицепс', 'Плечи', 'Пресс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $dumbbellRenegadeRow->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Держите тело в положении планки, не прогибайте поясницу.',
            'Тяните гантели к бедрам, избегая вращения корпуса.',
            'Сохраняйте стабильность в ногах, чтобы минимизировать движение таза.',
            'Убедитесь, что движение плавное и контролируемое, избегая рывков.'
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $dumbbellRenegadeRow->tips()->attach($tip->id);
        }
        
        // Упражнение: Barbell Incline Row
        $barbellInclineRow = Exercise::create([
            'name' => 'Тяга штанги на наклонной скамье',
            'video_url' => '/video/exercises/Barbell_Incline_Row.mp4',
            'thumbnail_url' => '/images/thumbnail/Barbell_Incline_Row.jpg',
            'min_weight_male' => 20,
            'max_weight_male' => 100,
            'min_weight_female' => 10,
            'max_weight_female' => 40,
            'description' => 'Тяга штанги на наклонной скамье — это упражнение для тренировки спины с акцентом на широчайшие мышцы, трапеции и бицепсы. С выполнением на наклонной скамье, угол позволяет прорабатывать верхнюю и среднюю части спины, улучшая осанку и развивая силу верхней части тела. Это движение помогает улучшить толщину спины и увеличить общую силу.',
        ]);
        
        // Связь с мышцами напряжения
        $muscleTensions = [
            'Спина' => 85,
            'Руки' => 10,
            'Плечи' => 5,
        ];
        foreach ($muscleTensions as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $barbellInclineRow->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Широчайшие', 'Трапеции', 'Бицепс', 'Плечи'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $barbellInclineRow->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Лягте на скамью, держите спину нейтральной, не округляйте ее.',
            'Подтягивайте штангу к животу, контролируя движение на всех этапах.',
            'Сосредоточьтесь на работе мышц спины, избегая излишней работы рук.',
            'Держите локти близко к телу, чтобы минимизировать нагрузку на плечи.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $barbellInclineRow->tips()->attach($tip->id);
        }
        
        // Упражнение: Kettlebell Swing
        $kettlebellSwing = Exercise::create([
            'name' => 'Махи kettlebell',
            'video_url' => '/video/exercises/Kettlebell_Swing.mp4',
            'thumbnail_url' => '/images/thumbnail/Kettlebell_Swing.jpg',
            'min_weight_male' => 12,
            'max_weight_male' => 40,
            'min_weight_female' => 6,
            'max_weight_female' => 24,
            'description' => 'Махи kettlebell — это динамичное упражнение, которое эффективно развивает ягодицы, бедра, спину и плечи. Оно выполняется с использованием гирь и помогает улучшить силу, выносливость, а также развить мощность и координацию. Это упражнение идеально подходит для тренировки всей задней цепи и улучшения общей физической формы.',
        ]);
        
        // Связь с мышцами
        $muscleData = [
            'Ноги' => 70,
            'Спина' => 20,
            'Плечи' => 10,
        ];
        
        foreach ($muscleData as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $kettlebellSwing->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Ягодицы', 'Квадрицепс', 'Подколенные сухожилия', 'Спина', 'Плечи'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $kettlebellSwing->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Держите спину прямой, избегайте округления поясницы.',
            'Махи должны исходить от бедер, а не за счет плеч.',
            'Используйте ноги и ягодицы для поднятия гири, а не спину или руки.',
            'Во время движения не задерживайте дыхание, поддерживайте ритм.'
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $kettlebellSwing->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Barbell Bench Press
        $barbellBenchPress = Exercise::create([
            'name' => 'Жим штанги лёжа',
            'video_url' => '/video/exercises/Barbell_Bench_Press.mp4',
            'thumbnail_url' => '/images/thumbnail/Barbell_Bench_Press.jpg',
            'min_weight_male' => 30,
            'max_weight_male' => 120,
            'min_weight_female' => 15,
            'max_weight_female' => 50,
            'description' => 'Жим штанги лёжа — одно из базовых упражнений для тренировки грудных мышц, также активно включающее трицепс и плечи. Это упражнение эффективно развивает силу верхней части тела, улучшая и увеличивая объём грудных мышц.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            'Грудь' => 70,
            'Руки' => 20,
            'Плечи' => 10,
        ];
        foreach ($muscles as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $barbellBenchPress->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Грудь', 'Трицепс', 'Плечи'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $barbellBenchPress->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Держите спину плотно прижатой к скамье, а ноги на полу для устойчивости.',
            'Опускайте штангу контролируемо до уровня груди и не «отскакивайте» ею от груди.',
            'Убедитесь, что локти слегка согнуты, не перенапрягайте их на верхней точке.',
            'Держите штангу на одном уровне, избегая перекосов в плечах.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $barbellBenchPress->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Dumbbell Bench Press
        $dumbbellBenchPress = Exercise::create([
            'name' => 'Жим гантелей лёжа',
            'video_url' => '/video/exercises/Dumbbell_Bench_Press.mp4',
            'thumbnail_url' => '/images/thumbnail/Dumbbell_Bench_Press.jpg',
            'min_weight_male' => 12,
            'max_weight_male' => 60,
            'min_weight_female' => 6,
            'max_weight_female' => 25,
            'description' => 'Жим гантелей лёжа — это отличная альтернатива классическому жиму штанги, которая позволяет больше развивать стабилизирующие мышцы. Это упражнение эффективно прорабатывает грудные мышцы, а также активно включает плечи и трицепсы. Использование гантелей позволяет увеличить амплитуду движения и добавить нагрузку на различные участки груди.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            'Грудь' => 70,
            'Руки' => 15,
            'Плечи' => 15,
        ];
        foreach ($muscles as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $dumbbellBenchPress->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Грудь', 'Трицепс', 'Плечи'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $dumbbellBenchPress->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Во время жима следите, чтобы локти находились на уровне груди, а не раскрывались слишком широко.',
            'Контролируйте движение, не позволяйте гантелям слишком быстро опускаться или подниматься.',
            'В нижней точке не касайтесь гантелями груди, чтобы сохранять напряжение в мышцах.',
            'Для большей стабилизации используйте небольшой угол наклона скамьи.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $dumbbellBenchPress->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Barbell Incline Bench Press
        $barbellInclineBenchPress = Exercise::create([
            'name' => 'Жим штанги с наклоном вверх',
            'video_url' => '/video/exercises/Barbell_Incline_Bench_Press.mp4',
            'thumbnail_url' => '/images/thumbnail/Barbell_Incline_Bench_Press.jpg',
            'min_weight_male' => 30,
            'max_weight_male' => 120,
            'min_weight_female' => 15,
            'max_weight_female' => 50,
            'description' => 'Жим штанги с наклоном вверх — это упражнение, направленное на развитие верхней части грудных мышц, а также плеч и трицепсов. С помощью наклонной скамьи увеличивается акцент на верхнюю часть груди, что помогает сбалансировать развитие всей грудной области. Упражнение активно используется для увеличения силы и массы верхней части тела.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            'Грудь' => 60,
            'Плечи' => 30,
            'Руки' => 10,
        ];
        foreach ($muscles as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $barbellInclineBenchPress->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Грудь', 'Плечи', 'Трицепс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $barbellInclineBenchPress->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Убедитесь, что ваша спина остается прижатой к скамье, а ноги стоят на полу для устойчивости.',
            'Опускайте штангу плавно и контролируемо, не позволяйте ей «падать» на грудь.',
            'Локти должны быть направлены под углом 45 градусов относительно корпуса, избегайте чрезмерного раскрытия.',
            'Во время жима концентрируйтесь на правильной технике и не используйте слишком тяжелые веса, если не уверены в правильности выполнения.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $barbellInclineBenchPress->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Dumbbell Incline Bench Press
        $dumbbellInclineBenchPress = Exercise::create([
            'name' => 'Жим гантелей с наклоном вверх',
            'video_url' => '/video/exercises/Dumbbell_Incline_Bench_Press.mp4',
            'thumbnail_url' => '/images/thumbnail/Dumbbell_Incline_Bench_Press.jpg',
            'min_weight_male' => 12,
            'max_weight_male' => 60,
            'min_weight_female' => 6,
            'max_weight_female' => 25,
            'description' => 'Жим гантелей с наклоном вверх — это упражнение, которое направлено на проработку верхней части грудных мышц, плеч и трицепсов. Использование гантелей позволяет увеличить амплитуду движения и развивать стабилизирующие мышцы, что делает упражнение более эффективным для общего развития силы и массы верхней части тела.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            'Грудь' => 60,
            'Плечи' => 30,
            'Руки' => 10,
        ];
        foreach ($muscles as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $dumbbellInclineBenchPress->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Грудь', 'Плечи', 'Трицепс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $dumbbellInclineBenchPress->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Следите, чтобы ваши локти не слишком широко расходились, держите их под углом 45 градусов к туловищу.',
            'Контролируйте движение на протяжении всего подхода, избегайте резких рывков.',
            'В нижней точке опускайте гантели до уровня груди, но не касайтесь ими тела, чтобы поддерживать напряжение в мышцах.',
            'Постоянно держите стабилизацию в плечах, избегайте чрезмерного подъема штанги за счет плечевого сустава.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $dumbbellInclineBenchPress->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Lever Chest Press
        $leverChestPress = Exercise::create([
            'name' => 'Жим на тренажере для груди',
            'video_url' => '/video/exercises/Lever_Chest_Press.mp4',
            'thumbnail_url' => '/images/thumbnail/Lever_Chest_Press.jpg',
            'min_weight_male' => 20,
            'max_weight_male' => 100,
            'min_weight_female' => 10,
            'max_weight_female' => 40,
            'description' => 'Жим на тренажере для груди — это отличное упражнение для развития грудных мышц с дополнительным акцентом на плечи и трицепсы. Использование тренажера обеспечивает правильное положение тела и стабильность во время выполнения, что позволяет сфокусироваться на эффективной работе целевых мышц, избегая лишней нагрузки на суставы.',
        ]);
        
        // Связь с мышцами
        $musclePercentages = [
            ['name' => 'Грудь', 'percentage' => 70],
            ['name' => 'Руки', 'percentage' => 20],
            ['name' => 'Плечи', 'percentage' => 10],
        ];
        foreach ($musclePercentages as $muscleData) {
            $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
            if ($muscle) {
                $leverChestPress->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentage']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Грудь', 'Трицепс', 'Плечи'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $leverChestPress->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Убедитесь, что спина плотно прижата к спинке сиденья, а ноги находятся на полу для стабильности.',
            'Держите локти под углом 45 градусов относительно корпуса, чтобы не перегружать плечевые суставы.',
            'Опускайте ручки тренажера до уровня груди и контролируйте движение при подъеме.',
            'Используйте полный диапазон движения, чтобы задействовать максимальное количество волокон в грудных мышцах.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $leverChestPress->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Lever Seated Fly
        $leverSeatedFly = Exercise::create([
            'name' => 'Разведение рук на тренажере сидя',
            'video_url' => '/video/exercises/Lever_Seated_Fly.mp4',
            'thumbnail_url' => '/images/thumbnail/Lever_Seated_Fly.jpg',
            'min_weight_male' => 10,
            'max_weight_male' => 70,
            'min_weight_female' => 5,
            'max_weight_female' => 30,
            'description' => 'Разведение рук на тренажере сидя — это эффективное упражнение для изолированной работы с грудными мышцами. Оно помогает развивать внутреннюю и среднюю части грудных мышц, а также активно включает плечи. Упражнение идеально подходит для увеличения массы груди, поскольку оно позволяет удерживать мышцы под постоянным напряжением.',
        ]);
        
        // Связь с мышцами
        $musclePercentages = [
            ['name' => 'Грудь', 'percentage' => 70],
            ['name' => 'Плечи', 'percentage' => 20],
            ['name' => 'Руки', 'percentage' => 10],
        ];
        foreach ($musclePercentages as $muscleData) {
            $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
            if ($muscle) {
                $leverSeatedFly->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentage']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Грудь', 'Плечи', 'Трицепс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $leverSeatedFly->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Сядьте прямо на скамью и удерживайте спину прямой, не округляя поясницу.',
            'Держите локти слегка согнутыми на протяжении всего движения.',
            'Разводите руки плавно, не допуская рывков.',
            'В нижней точке не позволяйте тренажеру полностью отпускать нагрузку, чтобы мышцы оставались напряженными.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $leverSeatedFly->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Dumbbell Decline Bench Press
        $dumbbellDeclinePress = Exercise::create([
            'name' => 'Жим гантелей с наклоном вниз',
            'video_url' => '/video/exercises/Dumbbell_Decline_Bench_Press.mp4',
            'thumbnail_url' => '/images/thumbnail/Dumbbell_Decline_Bench_Press.jpg',
            'min_weight_male' => 12,
            'max_weight_male' => 60,
            'min_weight_female' => 6,
            'max_weight_female' => 25,
            'description' => 'Жим гантелей с наклоном вниз — это упражнение, которое эффективно развивает нижнюю часть грудных мышц, а также активно включает трицепсы и плечи. Использование гантелей позволяет увеличить амплитуду движения и развить стабилизирующие мышцы, улучшая баланс и координацию. Это упражнение также снижает нагрузку на плечевые суставы по сравнению с традиционным жимом штанги.',
        ]);
        
        // Связь с мышцами
        $musclePercentages = [
            ['name' => 'Грудь', 'percentages' => 70],
            ['name' => 'Руки', 'percentages' => 20],
            ['name' => 'Плечи', 'percentages' => 10],
        ];
        foreach ($musclePercentages as $muscleData) {
            $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
            if ($muscle) {
                $dumbbellDeclinePress->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Грудь', 'Трицепс', 'Плечи'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $dumbbellDeclinePress->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Следите за углом наклона, чтобы сосредоточить нагрузку на нижней части груди.',
            'Опускайте гантели медленно и контролируемо до уровня груди, не касаясь ими тела.',
            'Локти должны быть под углом 45 градусов к туловищу, чтобы избежать излишней нагрузки на плечи.',
            'Не позволяйте гантелям двигаться слишком широко, держите их на одном уровне с грудью.'
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $dumbbellDeclinePress->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Cable Low Fly
        $cableLowFly = Exercise::create([
            'name' => 'Кроссовер на нижних блоках',
            'video_url' => '/video/exercises/Cable_Low_Fly.mp4',
            'thumbnail_url' => '/images/thumbnail/Cable_Low_Fly.jpg',
            'min_weight_male' => 10,
            'max_weight_male' => 70,
            'min_weight_female' => 5,
            'max_weight_female' => 30,
            'description' => 'Кроссовер на нижних блоках — это упражнение для грудных мышц, которое акцентирует нагрузку на нижнюю часть груди. Оно эффективно развивает мышечные волокна, улучшая форму и плотность грудных мышц. Использование кабелей позволяет развить стабильность и увеличить амплитуду движения, что делает упражнение очень эффективным для проработки грудных мышц.',
        ]);
        
        // Связь с мышцами
        $musclePercentages = [
            'Грудь' => 70,
            'Плечи' => 20,
            'Руки' => 10,
        ];
        foreach ($musclePercentages as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $cableLowFly->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Грудь', 'Плечи', 'Трицепс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $cableLowFly->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Держите корпус слегка наклонённым вперёд, чтобы акцентировать нагрузку на грудные мышцы.',
            'Контролируйте движение на протяжении всего подхода, не позволяйте блокам "падать" вниз.',
            'Разводите руки плавно, но в нижней точке не доводите их до полной изоляции, чтобы мышцы оставались напряжёнными.',
            'Сосредоточьтесь на сжатии грудных мышц при встрече кабелей в центре.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $cableLowFly->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Dumbbell Pullover
        $dumbbellPullover = Exercise::create([
            'name' => 'Тяга гантели за голову лёжа',
            'video_url' => '/video/exercises/Dumbbell_Pullover.mp4',
            'thumbnail_url' => '/images/thumbnail/Dumbbell_Pullover.jpg',
            'min_weight_male' => 12,
            'max_weight_male' => 60,
            'min_weight_female' => 6,
            'max_weight_female' => 25,
            'description' => 'Тяга гантели за голову лёжа — это упражнение, которое активно развивает грудные мышцы, спину и плечи. Гантель тянется через грудную клетку, активно растягивая грудные и спинальные мышцы, что помогает улучшить их форму и гибкость. Упражнение также вовлекает трицепс в качестве стабилизатора, но основной акцент на грудные и спинальные мышцы.',
        ]);
        
        // Связь с мышцами
        $musclePercentages = [
            'Грудь' => 50,
            'Спина' => 30,
            'Руки' => 10,
            'Плечи' => 10,
        ];
        foreach ($musclePercentages as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $dumbbellPullover->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Грудь', 'Спина', 'Трицепс', 'Плечи'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $dumbbellPullover->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Держите локти слегка согнутыми, чтобы избежать травм плечевых суставов.',
            'Опускайте гантель плавно за голову, не создавая резких движений, чтобы мышцы оставались напряжёнными.',
            'Не позволяйте гантели падать ниже уровня головы, держите контролируемую амплитуду движения.',
            'Постоянно следите за правильной техникой, чтобы минимизировать нагрузку на суставы и максимизировать эффект от упражнения.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $dumbbellPullover->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Smith Bench Press
        $smithBenchPress = Exercise::create([
            'name' => 'Жим штанги в Смит-машине',
            'video_url' => '/video/exercises/Smith_Bench_Press.mp4',
            'thumbnail_url' => '/images/thumbnail/Smith_Bench_Press.jpg',
            'min_weight_male' => 40,
            'max_weight_male' => 120,
            'min_weight_female' => 20,
            'max_weight_female' => 60,
            'description' => 'Жим штанги в Смит-машине — это упражнение для грудных мышц, которое позволяет поддерживать стабильность и правильную технику благодаря направляющим машини. Смит-машина исключает необходимость в стабилизирующих мышцах, что делает это упражнение более безопасным для новичков и позволяет сосредоточиться на проработке грудных мышц. Это упражнение также включает в работу трицепсы и плечи.',
        ]);
        
        // Связь с мышцами
        $muscleData = [
            ['name' => 'Грудь', 'percentage' => 70],
            ['name' => 'Руки', 'percentage' => 20],
            ['name' => 'Плечи', 'percentage' => 10],
        ];
        foreach ($muscleData as $data) {
            $muscle = MusclePercentage::where('name', $data['name'])->first();
            if ($muscle) {
                $smithBenchPress->musclePercentages()->attach($muscle->id, ['percentages' => $data['percentage']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Грудь', 'Трицепс', 'Плечи'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $smithBenchPress->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Убедитесь, что ваши руки находятся на ширине плеч, а локти слегка согнуты при опускании штанги.',
            'Держите спину плотно прижатой к скамье, не допускайте прогиба в пояснице.',
            'Используйте полный диапазон движения, опуская штангу до уровня груди.',
            'Не допускайте резких движений, плавно контролируйте подъем и опускание штанги.'
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $smithBenchPress->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Weighted Plate Push-up
        $weightedPushUp = Exercise::create([
            'name' => 'Отжимания с весом на спине',
            'video_url' => '/video/exercises/Weighted_Plate_Push_up.mp4',
            'thumbnail_url' => '/images/thumbnail/Weighted_Plate_Push_up.jpg',
            'min_weight_male' => 10,
            'max_weight_male' => 70,
            'min_weight_female' => 5,
            'max_weight_female' => 30,
            'description' => 'Отжимания с весом на спине — это вариация классических отжиманий, где на спину ложится дополнительный вес, что значительно увеличивает интенсивность упражнения. Это упражнение развивает грудные, плечевые и трицепсовые мышцы, а также помогает улучшить силу и выносливость верхней части тела.',
        ]);
        
        // Связь с мышцами
        $muscleData = [
            ['name' => 'Грудь', 'percentage' => 60],
            ['name' => 'Руки', 'percentage' => 20],
            ['name' => 'Плечи', 'percentage' => 20],
        ];
        foreach ($muscleData as $data) {
            $muscle = MusclePercentage::where('name', $data['name'])->first();
            if ($muscle) {
                $weightedPushUp->musclePercentages()->attach($muscle->id, ['percentages' => $data['percentage']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Грудь', 'Трицепс', 'Плечи'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $weightedPushUp->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Убедитесь, что вес равномерно распределен по спине, чтобы избежать нагрузки на поясницу.',
            'Держите тело прямым, не допускайте прогиба в спине.',
            'Опускайтесь плавно до уровня груди и выжимайте корпус вверх, контролируя движение.',
            'Начинайте с небольшого веса, чтобы привыкнуть к дополнительной нагрузке, и постепенно увеличивайте его по мере прогресса.'
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $weightedPushUp->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Cable Standing-Up Straight Crossovers
        $cableCrossovers = Exercise::create([
            'name' => 'Кроссовер стоя с прямыми руками',
            'video_url' => '/video/exercises/Cable_Standing_Up_Straight_Crossovers.mp4',
            'thumbnail_url' => '/images/thumbnail/Cable_Standing_Up_Straight_Crossovers.jpg',
            'min_weight_male' => 10,
            'max_weight_male' => 70,
            'min_weight_female' => 5,
            'max_weight_female' => 30,
            'description' => 'Кроссовер стоя с прямыми руками — это упражнение, в котором используются кабели для изолированной проработки грудных и плечевых мышц. В отличие от традиционного кроссовера, этот вариант акцентирует внимание на мышцах груди и плеч, активируя их через прямые руки, что также способствует развитию стабилизирующих мышц. Это упражнение отлично подходит для формирования формы груди и улучшения общей стабильности верхней части тела.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            ['name' => 'Грудь', 'percentage' => 60],
            ['name' => 'Плечи', 'percentage' => 30],
            ['name' => 'Руки', 'percentage' => 10],
        ];
        foreach ($muscles as $muscle) {
            $muscleEntity = MusclePercentage::where('name', $muscle['name'])->first();
            if ($muscleEntity) {
                $cableCrossovers->musclePercentages()->attach($muscleEntity->id, ['percentages' => $muscle['percentage']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Грудь', 'Плечи', 'Трицепс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $cableCrossovers->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Держите корпус немного наклонённым вперёд для лучшего напряжения грудных мышц.',
            'Используйте полный диапазон движения, сводя руки в центре и аккуратно возвращая их в исходное положение.',
            'Следите за тем, чтобы не было рывков — все движения должны быть плавными и контролируемыми.',
            'Сосредоточьтесь на сжиме грудных мышц, когда руки сходятся в центре.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $cableCrossovers->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Dumbbell Fly
        $dumbbellFly = Exercise::create([
            'name' => 'Разведения гантелей лёжа',
            'video_url' => '/video/exercises/Dumbbell_Fly.mp4',
            'thumbnail_url' => '/images/thumbnail/Dumbbell_Fly.jpg',
            'min_weight_male' => 8,
            'max_weight_male' => 40,
            'min_weight_female' => 4,
            'max_weight_female' => 18,
            'description' => 'Разведения гантелей лёжа — это изолированное упражнение для грудных мышц, которое акцентирует внимание на растяжении и сокращении грудных волокон. Оно помогает развить форму и плотность груди, улучшая общую пропорциональность. Разведения гантелей также активируют плечи и трицепсы в качестве стабилизаторов, но основная нагрузка ложится на грудные мышцы.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            ['name' => 'Грудь', 'percentage' => 80],
            ['name' => 'Плечи', 'percentage' => 15],
            ['name' => 'Руки', 'percentage' => 5],
        ];
        foreach ($muscles as $muscle) {
            $muscleEntity = MusclePercentage::where('name', $muscle['name'])->first();
            if ($muscleEntity) {
                $dumbbellFly->musclePercentages()->attach($muscleEntity->id, ['percentages' => $muscle['percentage']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Грудь', 'Плечи', 'Трицепс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $dumbbellFly->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Локти должны быть слегка согнуты, чтобы избежать травм плечевых суставов.',
            'Опускайте гантели плавно в стороны, контролируя движение, и не опускайте их слишком низко.',
            'При подъёме гантелей сосредотачивайтесь на сжатии грудных мышц, как будто пытаетесь соединить руки в центре.',
            'Используйте небольшой вес, чтобы избежать чрезмерной нагрузки на плечи и выполнить упражнение с правильной техникой.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $dumbbellFly->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Cable Incline Fly
        $cableInclineFly = Exercise::create([
            'name' => 'Кроссовер на наклонной скамье',
            'video_url' => '/video/exercises/Cable_Incline_Fly.mp4',
            'thumbnail_url' => '/images/thumbnail/Cable_Incline_Fly.jpg',
            'min_weight_male' => 10,
            'max_weight_male' => 60,
            'min_weight_female' => 5,
            'max_weight_female' => 25,
            'description' => 'Кроссовер на наклонной скамье — это упражнение для развития верхней части грудных мышц с использованием кабелей. Наклонная скамья помогает сосредоточить нагрузку на верхней части груди, улучшая её форму и плотность. Это упражнение также вовлекает плечи и трицепсы как стабилизаторы, что способствует общему улучшению верхней части тела.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            ['name' => 'Грудь', 'percentage' => 70],
            ['name' => 'Плечи', 'percentage' => 20],
            ['name' => 'Руки', 'percentage' => 10],
        ];
        foreach ($muscles as $muscleData) {
            $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
            if ($muscle) {
                $cableInclineFly->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentage']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Грудь', 'Плечи', 'Трицепс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $cableInclineFly->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Сохраняйте лёгкий наклон корпуса вперёд для увеличения напряжения в верхней части груди.',
            'Держите локти слегка согнутыми на протяжении всего движения.',
            'В верхней точке фокусируйтесь на сжиме грудных мышц, не позволяйте кабелям "падать" вниз.',
            'Выполняйте движение медленно, контролируя каждое повторение, чтобы избежать резких движений и травм.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $cableInclineFly->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Standing Plate Press
        $standingPlatePress = Exercise::create([
            'name' => 'Жим диска стоя',
            'video_url' => '/video/exercises/Standing_Plate_Press.mp4',
            'thumbnail_url' => '/images/thumbnail/Standing_Plate_Press.jpg',
            'min_weight_male' => 10,
            'max_weight_male' => 70,
            'min_weight_female' => 5,
            'max_weight_female' => 30,
            'description' => 'Жим диска стоя — это упражнение для плечевых мышц, которое также активирует грудные мышцы и трицепсы. Оно выполняется стоя, что дополнительно вовлекает мышцы кора в работу для стабилизации тела. Жим с диском развивает плечи, улучшая их форму и силу, а также помогает развить стабильность в верхней части тела.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            ['name' => 'Плечи', 'percentage' => 70],
            ['name' => 'Руки', 'percentage' => 20],
            ['name' => 'Грудь', 'percentage' => 10],
        ];
        foreach ($muscles as $muscleData) {
            $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
            if ($muscle) {
                $standingPlatePress->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentage']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Плечи', 'Трицепс', 'Грудь'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $standingPlatePress->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Стоите прямо, ноги на ширине плеч, не допускайте прогиба в спине.',
            'Держите локти слегка согнутыми, чтобы не перегружать плечевые суставы.',
            'Опускайте диск плавно до уровня груди и выжимайте его вверх, не теряя стабильности в корпусе.',
            'Контролируйте движение на протяжении всего подхода, чтобы избежать чрезмерного напряжения в плечах и спине.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $standingPlatePress->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Smith Standing Leg Calf Raise
        $smithCalfRaise = Exercise::create([
            'name' => 'Подъем на носки в Смит-машине стоя',
            'video_url' => '/video/exercises/Smith_Standing_Leg_Calf_Raise.mp4',
            'thumbnail_url' => '/images/thumbnail/Smith_Standing_Leg_Calf_Raise.jpg',
            'min_weight_male' => 40,
            'max_weight_male' => 120,
            'min_weight_female' => 20,
            'max_weight_female' => 80,
            'description' => 'Подъем на носки в Смит-машине стоя — это упражнение для проработки икроножных мышц. Смит-машина позволяет стабилизировать движение, позволяя сосредоточиться на максимальной амплитуде движения и увеличении нагрузки на икры. Это упражнение помогает развить как большие икроножные мышцы, так и мышцы-стабилизаторы нижней части тела.',
        ]);
        
        // Связь с мышцами
        $legs = MusclePercentage::where('name', 'Ноги')->first();
        if ($legs) {
            $smithCalfRaise->musclePercentages()->attach($legs->id, ['percentages' => 100]);
        }
        
        // Связь с фильтрами
        $filters = ['Икры'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $smithCalfRaise->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Убедитесь, что ваши плечи и спина плотно прижаты к стойкам машины.',
            'Используйте полный диапазон движения — поднимайтесь максимально высоко на носки и медленно опускайтесь в исходное положение.',
            'Контролируйте движение, избегайте рывков и резких изменений скорости.',
            'Для увеличения нагрузки добавляйте дополнительные веса постепенно, чтобы избегать перегрузки суставов.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $smithCalfRaise->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Sled Calf Press On Leg Press
        $sledCalfPress = Exercise::create([
            'name' => 'Подъем на носки на тренажере для ног',
            'video_url' => '/video/exercises/Sled_Calf_Press_On_Leg_Press.mp4',
            'thumbnail_url' => '/images/thumbnail/Sled_Calf_Press_On_Leg_Press.jpg',
            'min_weight_male' => 50,
            'max_weight_male' => 200,
            'min_weight_female' => 30,
            'max_weight_female' => 120,
            'description' => 'Подъем на носки на тренажере для ног — это упражнение для проработки икроножных мышц, выполняемое с использованием тренажера для ног (седло или тренажер с платформой). Оно позволяет значительно нагружать икры, не перегружая коленные суставы. Это упражнение особенно эффективно для изолированной тренировки икроножных мышц.',
        ]);
        
        // Связь с мышцами
        $legs = MusclePercentage::where('name', 'Ноги')->first();
        if ($legs) {
            $sledCalfPress->musclePercentages()->attach($legs->id, ['percentages' => 100]);
        }
        
        // Связь с фильтрами
        $filters = ['Икры'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $sledCalfPress->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Следите за тем, чтобы ваши ноги были расположены на платформе так, чтобы на носки приходилась вся нагрузка.',
            'Опускайтесь вниз до комфортного для вас уровня и поднимайтесь максимально высоко.',
            'Не используйте слишком большой вес на начальных этапах, чтобы избежать травм.',
            'Контролируйте движение, избегайте резких рывков и всегда выполняйте подъемы плавно.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $sledCalfPress->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Barbell Floor Calf Raise
        $barbellFloorCalfRaise = Exercise::create([
            'name' => 'Подъем на носки с штангой',
            'video_url' => '/video/exercises/Barbell_Floor_Calf_Raise.mp4',
            'thumbnail_url' => '/images/thumbnail/Barbell_Floor_Calf_Raise.jpg',
            'min_weight_male' => 30,
            'max_weight_male' => 140,
            'min_weight_female' => 10,
            'max_weight_female' => 60,
            'description' => 'Подъем на носки с штангой — упражнение, направленное на развитие икроножных мышц. Выполняется с использованием штанги, которая размещается на плечах. Это упражнение помогает увеличить силу и выносливость икроножных мышц, а также улучшить их форму и объем. Подъемы на носки способствуют стабилизации голеностопного сустава и могут помочь в предотвращении травм нижних конечностей.',
        ]);
        
        // Связь с мышцами
        $legs = MusclePercentage::where('name', 'Ноги')->first();
        if ($legs) {
            $barbellFloorCalfRaise->musclePercentages()->attach($legs->id, ['percentages' => 100]);
        }
        
        // Связь с фильтрами
        $filters = ['Икры'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $barbellFloorCalfRaise->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная постановка ног: Расположите ноги на ширине плеч, чтобы обеспечить стабильность во время выполнения упражнения.',
            'Контроль движения: Медленно поднимайтесь на носки, максимально сокращая икроножные мышцы в верхней точке, и плавно опускайтесь обратно.',
            'Держите спину прямо: Избегайте прогиба в пояснице, чтобы минимизировать нагрузку на спину и сосредоточиться на работе икр.',
            'Дыхание: Выдыхайте при подъеме и вдыхайте при опускании штанги для поддержания ритма и стабильности.',
            'Использование полного диапазона движения: Полностью опускайтесь вниз и поднимайтесь как можно выше, чтобы максимально задействовать икроножные мышцы.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $barbellFloorCalfRaise->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Lever Seated Calf Raise
        $leverSeatedCalfRaise = Exercise::create([
            'name' => 'Сидячий подъем на носки на тренажере',
            'video_url' => '/video/exercises/Lever_Seated_Calf_Raise.mp4',
            'thumbnail_url' => '/images/thumbnail/Lever_Seated_Calf_Raise.jpg',
            'min_weight_male' => 40,
            'max_weight_male' => 200,
            'min_weight_female' => 20,
            'max_weight_female' => 100,
            'description' => 'Сидячий подъем на носки на тренажере — это упражнение, направленное на развитие икроножных мышц (икры). Выполняется сидя на специальном тренажере с использованием рычага или дополнительного веса. Упражнение позволяет изолировать икры, минимизируя участие других мышц, что способствует их более эффективному росту и укреплению. Регулярное выполнение сидячих подъемов на носки помогает улучшить силу и выносливость икроножных мышц, а также способствует лучшей стабилизации голеностопного сустава и общей устойчивости нижних конечностей.',
        ]);
        
        // Связь с мышцами
        if ($legs) {
            $leverSeatedCalfRaise->musclePercentages()->attach($legs->id, ['percentages' => 100]);
        }
        
        // Связь с фильтрами
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $leverSeatedCalfRaise->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная посадка: Сидите прямо на тренажере, убедившись, что подошвы ног полностью закреплены на платформе. Спина должна быть прямой, а колени слегка согнуты.',
            'Контроль движения: Поднимайтесь на носки максимально высоко, полностью сокращая икроножные мышцы в верхней точке. Медленно опускайтесь обратно, контролируя движение для полного растяжения мышц.',
            'Полный диапазон движений: Выполняйте упражнение через полный диапазон движений, чтобы обеспечить максимальную активацию мышц и предотвратить частичные сокращения.',
            'Равномерное распределение веса: Убедитесь, что вес распределен равномерно на обе ноги, избегая переноса нагрузки на одну сторону тела.',
            'Темп выполнения: Поддерживайте умеренный темп выполнения упражнения, избегая рывков и резких движений, чтобы минимизировать риск травм и обеспечить эффективную работу мышц.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $leverSeatedCalfRaise->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Dumbbell Standing Single Leg Calf Raise
        $dumbbellSingleLegCalfRaise = Exercise::create([
            'name' => 'Подъем на носки с гантелью на одной ноге',
            'video_url' => '/video/exercises/Dumbbell_Standing_Single_Leg_Calf_Raise.mp4',
            'thumbnail_url' => '/images/thumbnail/Dumbbell_Standing_Single_Leg_Calf_Raise.jpg',
            'min_weight_male' => 10,
            'max_weight_male' => 50,
            'min_weight_female' => 5,
            'max_weight_female' => 30,
            'description' => 'Подъем на носки с гантелью на одной ноге — это упражнение, направленное на развитие икроножных мышц. Выполняется стоя на одной ноге с дополнительным весом в виде гантели, которую держат в противоположной руке для улучшения баланса. Это упражнение не только усиливает икры, но и развивает стабилизирующие мышцы нижних конечностей, улучшает баланс и координацию.',
        ]);
        
        // Связь с мышцами
        $legsMuscle = MusclePercentage::where('name', 'Ноги')->first();
        if ($legsMuscle) {
            $dumbbellSingleLegCalfRaise->musclePercentages()->attach($legsMuscle->id, ['percentages' => 100]);
        }
        
        // Связь с фильтрами
        $filters = ['Икры'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $dumbbellSingleLegCalfRaise->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Держите корпус прямо, плечи расправлены, а взгляд направлен вперед.',
            'Поднимайтесь на носок максимально высоко, полностью сокращая икры, затем медленно опускайтесь в исходное положение.',
            'Используйте опору для поддержки при необходимости.',
            'Вдыхайте при опускании гантели и выдыхайте при подъеме.',
            'Начинайте с легких гантелей и постепенно увеличивайте вес по мере укрепления мышц.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $dumbbellSingleLegCalfRaise->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Dumbbell Standing Calf Raise
        $dumbbellStandingCalfRaise = Exercise::create([
            'name' => 'Подъем на носки с гантелями',
            'video_url' => '/video/exercises/Dumbbell_Standing_Calf_Raise.mp4',
            'thumbnail_url' => '/images/thumbnail/Dumbbell_Standing_Calf_Raise.jpg',
            'min_weight_male' => 10,
            'max_weight_male' => 50,
            'min_weight_female' => 5,
            'max_weight_female' => 30,
            'description' => 'Подъем на носки с гантелями — это упражнение, направленное на развитие икроножных мышц. Выполняется стоя с гантелями, удерживаемыми в руках по бокам тела или закрепленными на плечах. Это упражнение способствует увеличению силы и массы икр.',
        ]);
        
        // Связь с мышцами
        if ($legsMuscle) {
            $dumbbellStandingCalfRaise->musclePercentages()->attach($legsMuscle->id, ['percentages' => 100]);
        }
        
        // Связь с фильтрами
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $dumbbellStandingCalfRaise->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Расположите ноги на ширине плеч, равномерно распределяя вес тела.',
            'Поднимайтесь на носки максимально высоко и опускайтесь медленно.',
            'Держите спину прямой и корпус напряженным.',
            'Держите гантели по бокам тела или закрепите их на плечах.',
            'Вдыхайте при опускании гантелей и выдыхайте при подъеме.',
            'Начинайте с минимального веса и постепенно увеличивайте нагрузку.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $dumbbellStandingCalfRaise->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Kettlebell Standing Calf Raise
        $kettlebellStandingCalfRaise = Exercise::create([
            'name' => 'Подъем на носки со гири стоя',
            'video_url' => '/video/exercises/Kettlebell_Standing_Calf_Raise.mp4',
            'thumbnail_url' => '/images/thumbnail/Kettlebell_Standing_Calf_Raise.jpg',
            'min_weight_male' => 16,
            'max_weight_male' => 40,
            'min_weight_female' => 8,
            'max_weight_female' => 24,
            'description' => 'Подъем на носки со гири стоя — это упражнение для развития икроножных мышц, выполняемое с использованием гири. Оно способствует увеличению силы и массы икр, а также улучшает баланс и стабилизацию нижних конечностей. Во время выполнения упражнения используется дополнительная нагрузка, что повышает эффективность тренировки и способствует лучшей проработке мышц.',
        ]);
        
        // Связь с мышцами
        $legs = MusclePercentage::where('name', 'Ноги')->first();
        if ($legs) {
            $kettlebellStandingCalfRaise->musclePercentages()->attach($legs->id, ['percentages' => 100]);
        }
        
        // Связь с фильтрами
        $filters = ['Икры', 'Предплечья'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $kettlebellStandingCalfRaise->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная постановка ног: Расположите ноги на ширине плеч, равномерно распределяя вес тела, чтобы обеспечить стабильность во время подъема.',
            'Контроль движения: Поднимайтесь на носки медленно и плавно, полностью сокращая икроножные мышцы в верхней точке, и опускайтесь контролируемо для максимальной нагрузки.',
            'Стабильная спина: Держите спину прямой и избегайте раскачивания тела, чтобы изолировать нагрузку на икры и минимизировать риск травм.',
            'Держите гирю правильно: Держите гирю крепко, но расслабленно, чтобы избежать чрезмерного напряжения в предплечьях.',
            'Дыхание: Вдыхайте при опускании гири и выдыхайте при подъеме, поддерживая ритмичное дыхание на протяжении всего упражнения.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $kettlebellStandingCalfRaise->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Barbell Seated Calf Raise
        $barbellSeatedCalfRaise = Exercise::create([
            'name' => 'Сидячий подъем на носки со штангой',
            'video_url' => '/video/exercises/Barbell_Seated_Calf_Raise.mp4',
            'thumbnail_url' => '/images/thumbnail/Barbell_Seated_Calf_Raise.jpg',
            'min_weight_male' => 40,
            'max_weight_male' => 140,
            'min_weight_female' => 20,
            'max_weight_female' => 60,
            'description' => 'Сидячий подъем на носки со штангой — это упражнение, направленное на развитие икроножных мышц, особенно мышцы-стоячей (soleus). Выполняется в сидячем положении, что позволяет лучше изолировать икры и снизить нагрузку на ахиллово сухожилие. Штанга размещается на верхней части бедер или на плечах, обеспечивая устойчивость во время выполнения упражнения. Регулярное выполнение сидячих подъемов на носки способствует увеличению силы и массы икроножных мышц, улучшению их выносливости и общей стабилизации голеностопного сустава.',
        ]);
        
        // Связь с мышцами
        if ($legs) {
            $barbellSeatedCalfRaise->musclePercentages()->attach($legs->id, ['percentages' => 100]);
        }
        
        // Связь с фильтрами
        $filters = ['Икры'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $barbellSeatedCalfRaise->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная посадка: Сядьте на скамью с прямой спиной, ноги разместите на платформе так, чтобы пятки свисали за край. Убедитесь, что штанга надежно закреплена на бедрах.',
            'Полный диапазон движений: Поднимайтесь на носки максимально высоко, полностью сокращая икроножные мышцы в верхней точке, и опускайтесь до полного растяжения икр без задержки в нижней точке.',
            'Контроль и плавность: Выполняйте движение плавно и контролируемо, избегая рывков и резких движений, чтобы минимизировать риск травм и обеспечить максимальную эффективность упражнения.',
            'Положение стоп: Экспериментируйте с шириной постановки ног и направлением носков (вперед, наружу, внутрь) для разнообразия нагрузки на разные части икроножных мышц.',
            'Дыхание: Вдыхайте при опускании штанги и выдыхайте при подъеме, поддерживая ритмичное и глубокое дыхание на протяжении всего упражнения.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $barbellSeatedCalfRaise->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Barbell Full Squat
        $barbellFullSquat = Exercise::create([
            'name' => 'Приседания со штангой',
            'video_url' => '/video/exercises/Barbell_Full_Squat.mp4',
            'thumbnail_url' => '/images/thumbnail/Barbell_Full_Squat.jpg',
            'min_weight_male' => 60,
            'max_weight_male' => 200,
            'min_weight_female' => 40,
            'max_weight_female' => 120,
            'description' => 'Приседания со штангой — базовое силовое упражнение, направленное на развитие мышц ног и ягодиц. Выполняется с использованием штанги, расположенной на трапециях или передними плечами (в зависимости от вариации). Приседания со штангой эффективно развивают квадрицепсы, ягодичные мышцы, а также укрепляют мышцы спины и кора. Это упражнение улучшает общую силу, выносливость и стабильность нижней части тела, что положительно сказывается на спортивных показателях и повседневной активности.',
        ]);
        
        // Связь с мышцами
        $muscleData = [
            'Ноги' => 70,
            'Спина' => 15,
            'Пресс' => 10,
        ];
        foreach ($muscleData as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $barbellFullSquat->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Квадрицепсы', 'Ягодицы', 'Нижняя часть спины', 'Пресс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $barbellFullSquat->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная постановка ног: Расположите ноги на ширине плеч или чуть шире, с носками слегка развернутыми наружу для оптимальной устойчивости и активации мышц.',
            'Сохранение нейтрального позвоночника: Держите спину прямой и избегайте округления или чрезмерного прогиба, чтобы минимизировать нагрузку на позвоночник и предотвратить травмы.',
            'Глубина приседа: Опускайтесь до уровня, при котором бедра становятся параллельны полу или ниже, обеспечивая максимальную активацию мышц ног и ягодиц.',
            'Контроль дыхания: Вдыхайте при опускании и выдыхайте при подъеме, поддерживая стабильное дыхание для улучшения контроля и выносливости.',
            'Использование полного диапазона движений: Выполняйте приседания медленно и контролируемо, концентрируясь на качестве выполнения каждого повторения для достижения максимальной эффективности.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $barbellFullSquat->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Lever Angled Leg Press
        $leverAngledLegPress = Exercise::create([
            'name' => 'Жим ногами на наклонной платформе',
            'video_url' => '/video/exercises/Lever_Angled_Leg_Press.mp4',
            'thumbnail_url' => '/images/thumbnail/Lever_Angled_Leg_Press.jpg',
            'min_weight_male' => 60,
            'max_weight_male' => 400,
            'min_weight_female' => 40,
            'max_weight_female' => 180,
            'description' => 'Жим ногами на наклонной платформе — это упражнение, направленное на развитие мышц нижней части тела, особенно квадрицепсов, ягодиц и подколенных сухожилий. Выполняется на специальном тренажёре, где пользователь сидит, опирается на наклонную платформу и выжимает её ногами, контролируя движение вверх и вниз. Это упражнение помогает увеличить силу и массу мышц ног, улучшить выносливость и общую физическую форму. Жим ногами на наклонной платформе также способствует улучшению стабильности коленных суставов и снижению нагрузки на позвоночник по сравнению с некоторыми другими упражнениями для ног.',
        ]);
        
        // Связь с мышцами
        $muscleData = [
            'Ноги' => 95,
            'Пресс' => 5,
        ];
        foreach ($muscleData as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $leverAngledLegPress->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Квадрицепсы', 'Ягодицы', 'Подколенные сухожилия', 'Пресс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $leverAngledLegPress->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная постановка ног: Расположите ноги на платформе на ширине плеч или чуть шире, чтобы равномерно распределить нагрузку между квадрицепсами и ягодицами.',
            'Контроль движения: Выполняйте жим плавно и контролируемо, избегая резких рывков, чтобы минимизировать риск травм и обеспечить максимальную эффективность упражнения.',
            'Глубина приседа: Опускайте платформу до тех пор, пока ваши колени не достигнут угла примерно 90 градусов, чтобы обеспечить оптимальную активацию мышц и избежать перенапряжения суставов.',
            'Стабильное положение: Держите спину плотно прижатой к спинке тренажёра и избегайте чрезмерного прогиба в пояснице, чтобы сохранить правильную технику и снизить нагрузку на позвоночник.',
            'Дыхание: Вдыхайте при опускании платформы и выдыхайте при выжимании, поддерживая ритмичное дыхание на протяжении всего упражнения.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $leverAngledLegPress->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Sled Hack Squat
        $sledHackSquat = Exercise::create([
            'name' => 'Хак-приседания на санях',
            'video_url' => '/video/exercises/Sled_Hack_Squat.mp4',
            'thumbnail_url' => '/images/thumbnail/Sled_Hack_Squat.jpg',
            'min_weight_male' => 50,
            'max_weight_male' => 200,
            'min_weight_female' => 30,
            'max_weight_female' => 100,
            'description' => 'Хак-приседания на санях — это силовое упражнение, направленное на развитие мышц ног, особенно квадрицепсов. Упражнение выполняется с использованием саней, которые обеспечивают дополнительное сопротивление, позволяя увеличить нагрузку на мышцы. Хак-приседания на санях способствуют увеличению силы и массы нижней части тела, а также укрепляют ягодичные мышцы и нижнюю часть спины. Это упражнение помогает улучшить общую выносливость и стабильность нижних конечностей.',
        ]);
        
        // Связь с мышцами
        $musclePercentages = [
            'Ноги' => 90,
            'Спина' => 10,
        ];
        foreach ($musclePercentages as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $sledHackSquat->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Квадрицепс', 'Ягодицы', 'Подколенные сухожилия', 'Нижняя часть спины', 'Икры'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $sledHackSquat->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная постановка ног: Расположите ноги на ширине плеч, ступни слегка развернуты наружу для оптимальной активации квадрицепсов.',
            'Контроль движения: Медленно опускайтесь в присед, удерживая спину прямой, и полностью разгибайте колени при подъеме, избегая рывков.',
            'Удержание тела: Держите корпус напряженным и избегайте прогиба в пояснице, чтобы минимизировать риск травм и максимизировать нагрузку на целевые мышцы.',
            'Дыхание: Вдыхайте при опускании в присед и выдыхайте при подъеме, поддерживая ритмичное дыхание на протяжении всего упражнения.',
            'Амплитуда движения: Выполняйте приседания через полный диапазон движений, обеспечивая полную активацию мышц и эффективное развитие силы.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $sledHackSquat->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Dumbbell Goblet Bulgarian Split Squat
        $gobletSplitSquat = Exercise::create([
            'name' => 'Болгарский сплит-присед с гантелей "Гоблет"',
            'video_url' => '/video/exercises/Dumbbell_Goblet_Bulgarian_Split_Squat.mp4',
            'thumbnail_url' => '/images/thumbnail/Dumbbell_Goblet_Bulgarian_Split_Squat.jpg',
            'min_weight_male' => 20,
            'max_weight_male' => 50,
            'min_weight_female' => 10,
            'max_weight_female' => 30,
            'description' => 'Болгарский сплит-присед с гантелей "Гоблет" — это одностороннее упражнение для ног, направленное на развитие квадрицепсов, ягодиц и подколенных сухожилий, при этом активно вовлекается пресс для стабилизации тела. Упражнение выполняется с гантелей, удерживаемой на уровне груди ("гоблет" позиция), в положении сплит-приседа, где задняя нога размещается на возвышении (например, на скамье). Это упражнение улучшает баланс, координацию и силу нижних конечностей, а также способствует развитию стабильности корпуса.',
        ]);
        
        // Связь с мышцами
        $musclePercentages = [
            'Ноги' => 70,
            'Пресс' => 20,
            'Спина' => 10,
        ];
        foreach ($musclePercentages as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $gobletSplitSquat->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Квадрицепс', 'Ягодицы', 'Подколенные сухожилия', 'Пресс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $gobletSplitSquat->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная постановка корпуса: Держите торс прямым и активируйте мышцы пресса, чтобы поддерживать равновесие и избежать наклона вперед.',
            'Положение колена: Убедитесь, что переднее колено следует за направлением стопы и не выходит за пределы пальцев ног, чтобы минимизировать нагрузку на суставы.',
            'Глубина приседа: Опускайтесь до тех пор, пока переднее бедро не станет параллельным полу, обеспечивая максимальное вовлечение мышц ног.',
            'Контролируемое движение: Выполняйте упражнение плавно и контролируемо, избегая рывков и раскачиваний, чтобы максимально изолировать целевые мышцы.',
            'Использование возвышения: Разместите заднюю ногу на устойчивой поверхности, такой как скамья или ступенька, чтобы обеспечить правильную технику и безопасность выполнения упражнения.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $gobletSplitSquat->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Lever Leg Extension
        $leverLegExtension = Exercise::create([
            'name' => 'Разгибание ног в тренажёре',
            'video_url' => '/video/exercises/Lever_Leg_Extension.mp4',
            'thumbnail_url' => '/images/thumbnail/Lever_Leg_Extension.jpg',
            'min_weight_male' => 40,
            'max_weight_male' => 120,
            'min_weight_female' => 20,
            'max_weight_female' => 60,
            'description' => 'Разгибание ног в тренажёре Левер — это изолирующее упражнение, направленное на развитие квадрицепсов (четырёхглавой мышцы бедра). Выполняется в специальном тренажёре, где пользователь сидит, фиксируя ноги под валиками, и совершает движение разгибания коленей. Это упражнение помогает увеличить силу и массу передней части бедра, улучшить тонус мышц ног и повысить общую выносливость.',
        ]);
        
        // Связь с мышцами
        $legs = MusclePercentage::where('name', 'Ноги')->first();
        if ($legs) {
            $leverLegExtension->musclePercentages()->attach($legs->id, ['percentages' => 100]);
        }
        
        // Связь с фильтрами
        $filters = ['Квадрицепс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $leverLegExtension->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная посадка: Сидите прямо, спина полностью упирается в спинку тренажёра. Убедитесь, что ваши колени находятся в одной линии с осью вращения тренажёра.',
            'Контроль движения: Медленно разгибайте ноги до полного выпрямления, не блокируя коленные суставы в конце движения. Затем плавно возвращайтесь в исходное положение, контролируя нагрузку.',
            'Дыхание: Выдыхайте при разгибании ног и вдыхайте при возвращении в исходное положение, поддерживая ритмичное дыхание.',
            'Амплитуда движений: Используйте полный диапазон движений для максимальной эффективности упражнения. Избегайте сокращений или рывков.',
            'Вес нагрузки: Выбирайте вес, который позволяет выполнять упражнение с правильной техникой. Избегайте чрезмерного веса, чтобы предотвратить травмы коленных суставов.',
            'Фокус на мышцах: Сосредоточьтесь на сокращении квадрицепсов во время разгибания ног, минимизируя участие других мышц для изоляции целевой группы.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $leverLegExtension->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Smith Squat
        $smithSquat = Exercise::create([
            'name' => 'Приседания в тренажере Смита',
            'video_url' => '/video/exercises/Smith_Squat.mp4',
            'thumbnail_url' => '/images/thumbnail/Smith_Squat.jpg',
            'min_weight_male' => 40,
            'max_weight_male' => 200,
            'min_weight_female' => 20,
            'max_weight_female' => 100,
            'description' => 'Приседания в тренажере Смита — это упражнение для нижней части тела, выполняемое с использованием тренажера Смита, который обеспечивает стабильность штанги во время выполнения приседаний. Это упражнение способствует развитию квадрицепсов, ягодичных мышц и подколенных сухожилий, а также укрепляет мышцы спины и корпуса.',
        ]);
        
        // Связь с мышцами
        $smithSquatMuscles = [
            ['name' => 'Ноги', 'percentage' => 60],
            ['name' => 'Спина', 'percentage' => 25],
            ['name' => 'Пресс', 'percentage' => 15],
        ];
        foreach ($smithSquatMuscles as $muscleData) {
            $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
            if ($muscle) {
                $smithSquat->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentage']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Квадрицепс', 'Ягодицы', 'Подколенные сухожилия', 'Нижняя часть спины'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $smithSquat->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная постановка ног: Расположите ноги на ширине плеч, носки слегка развернуты наружу для обеспечения правильного угла приседа.',
            'Контроль спины: Держите спину прямой и напряженной, избегайте округления или чрезмерного прогиба в пояснице.',
            'Полный диапазон движения: Опускайтесь до уровня, при котором бедра параллельны полу или чуть ниже, обеспечивая полную активацию мышц.',
            'Использование дыхания: Вдыхайте при опускании и выдыхайте при подъеме, поддерживая ритмичное дыхание для стабильности корпуса.',
            'Безопасность: Убедитесь, что штанга надежно закреплена в тренажере Смита перед началом упражнения, чтобы избежать соскальзывания.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $smithSquat->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Dumbbell Walking Lunge
        $dumbbellWalkingLunge = Exercise::create([
            'name' => 'Выпады с гантелями',
            'video_url' => '/video/exercises/Dumbbell_Walking_Lunge.mp4',
            'thumbnail_url' => '/images/thumbnail/Dumbbell_Walking_Lunge.jpg',
            'min_weight_male' => 10,
            'max_weight_male' => 50,
            'min_weight_female' => 5,
            'max_weight_female' => 30,
            'description' => 'Выпады с гантелями — это эффективное упражнение для развития мышц нижней части тела, включая квадрицепсы, ягодичные мышцы и подколенные сухожилия. Выполняется с удерживанием гантелей по бокам тела. Во время выполнения упражнения вы делаете шаг вперед, опускаясь до угла в 90 градусов в обоих коленях, затем возвращаетесь в исходное положение и повторяете движение с другой ноги. Это упражнение улучшает силу, баланс и стабильность, способствует развитию мышечной массы и выносливости, а также помогает улучшить координацию движений.',
        ]);
        
        // Связь с мышцами
        $musclePercentages = [
            'Ноги' => 75,
            'Пресс' => 15,
            'Руки' => 10,
        ];
        foreach ($musclePercentages as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $dumbbellWalkingLunge->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Квадрицепс', 'Ягодицы', 'Подколенные сухожилия', 'Пресс', 'Предплечья'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $dumbbellWalkingLunge->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная постановка ног: Делайте длинные шаги вперед, удерживая ноги на ширине плеч, чтобы обеспечить максимальную нагрузку на квадрицепсы и ягодицы.',
            'Сохранение прямой спины: Держите спину прямо и избегайте прогиба туловища, чтобы минимизировать нагрузку на поясницу.',
            'Контроль движения: Опускайтесь медленно и контролируемо, полностью разгибая колено задней ноги при возвращении в исходное положение.',
            'Удержание гантелей: Держите гантели устойчиво по бокам тела, не позволяйте им качаться, чтобы изолировать нагрузку на мышцы ног.',
            'Дыхание: Вдыхайте при опускании тела и выдыхайте при возвращении в исходное положение, поддерживая ритмичное дыхание на протяжении всего упражнения.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $dumbbellWalkingLunge->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Barbell Lunge
        $barbellLunge = Exercise::create([
            'name' => 'Выпады со штангой',
            'video_url' => '/video/exercises/Barbell_Lunge.mp4',
            'thumbnail_url' => '/images/thumbnail/Barbell_Lunge.jpg',
            'min_weight_male' => 40,
            'max_weight_male' => 100,
            'min_weight_female' => 20,
            'max_weight_female' => 60,
            'description' => 'Выпады со штангой — базовое силовое упражнение, направленное на развитие мышц нижней части тела. Выполняется с использованием штанги, размещенной на плечах, что позволяет увеличить нагрузку на квадрицепсы, ягодицы и подколенные сухожилия. Упражнение способствует улучшению баланса и координации, а также развитию силы и массы мышц ног. Регулярное выполнение выпадов со штангой помогает укрепить стабилизирующие мышцы корпуса и улучшить общую функциональную силу.',
        ]);
        
        // Связь с мышцами
        $musclePercentages = [
            'Ноги' => 90,
            'Пресс' => 10,
        ];
        foreach ($musclePercentages as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $barbellLunge->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Квадрицепсы', 'Ягодицы', 'Подколенные сухожилия', 'Пресс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $barbellLunge->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная осанка: Держите спину прямой и смотрите вперед, чтобы избежать наклона вперед и сохранить баланс.',
            'Длина шага: Сделайте шаг достаточной длины, чтобы колено передней ноги не выходило за линию носка, снижая нагрузку на коленные суставы.',
            'Контроль движения: Медленно опускайтесь и поднимайтесь, контролируя каждое движение, чтобы избежать рывков и обеспечить максимальную эффективность упражнения.',
            'Ровное дыхание: Вдыхайте при опускании тела и выдыхайте при подъеме, поддерживая ритмичное дыхание на протяжении всего подхода.',
            'Выбор веса: Используйте такой вес, который позволяет выполнять упражнение с правильной техникой. Начинайте с меньшего веса и постепенно увеличивайте нагрузку по мере роста силы и уверенности в выполнении упражнения.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $barbellLunge->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Barbell Box Squat
        $barbellBoxSquat = Exercise::create([
            'name' => 'Приседания со штангой на ящике',
            'video_url' => '/video/exercises/Barbell_Box_Squat.mp4',
            'thumbnail_url' => '/images/thumbnail/Barbell_Box_Squat.jpg',
            'min_weight_male' => 80,
            'max_weight_male' => 200,
            'min_weight_female' => 40,
            'max_weight_female' => 120,
            'description' => 'Приседания со штангой на ящике — это упражнение, направленное на развитие мышц ног, особенно квадрицепсов и ягодиц, а также укрепление нижней части спины и пресса. Выполнение приседаний с использованием ящика помогает контролировать глубину приседа, обеспечивая безопасность и правильную технику выполнения. Это упражнение улучшает силу и выносливость нижней части тела, способствует развитию мышечной массы и общей функциональной силы, необходимой для различных спортивных и повседневных активностей.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            'Ноги' => 70,
            'Спина' => 20,
            'Пресс' => 10,
        ];
        foreach ($muscles as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $barbellBoxSquat->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Квадрицепс', 'Ягодицы', 'Нижняя часть спины'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $barbellBoxSquat->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Постановка ящика: Убедитесь, что ящик устойчив и находится на правильной высоте, позволяющей вам садиться и вставать с минимальным напряжением на коленные суставы.',
            'Положение ног: Расположите ноги на ширине плеч или чуть шире, носки слегка развернуты наружу для оптимальной активации квадрицепсов и ягодиц.',
            'Контроль дыхания: Вдыхайте при опускании вниз и выдыхайте при подъеме, поддерживая стабильный ритм дыхания.',
            'Прямая спина: Держите спину прямой и грудь поднятой, избегайте округления или чрезмерного прогиба позвоночника для предотвращения травм.',
            'Глубина приседа: Опускайтесь до момента, когда бедра будут параллельны полу или чуть ниже, обеспечивая полный рабочий диапазон для мышц ног.',
            'Использование цепей или резинок (опционально): Для продвинутых атлетов можно использовать цепи или резинки для добавления сопротивления в верхней фазе движения, что способствует увеличению силы и мощности.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $barbellBoxSquat->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Weighted Sissy Squat
        $weightedSissySquat = Exercise::create([
            'name' => 'Сисси-приседания с отягощением',
            'video_url' => '/video/exercises/Weighted_Sissy_Squat.mp4',
            'thumbnail_url' => '/images/thumbnail/Weighted_Sissy_Squat.jpg',
            'min_weight_male' => 30,
            'max_weight_male' => 140,
            'min_weight_female' => 15,
            'max_weight_female' => 60,
            'description' => 'Сисси-приседания с отягощением — это упражнение, ориентированное на развитие квадрицепсов. Выполняется с добавлением веса, что увеличивает нагрузку на переднюю часть бедер и способствует росту силы и массы мышц ног. Во время выполнения упражнения важно сохранять корпус прямым и контролировать движение, что позволяет максимально изолировать квадрицепсы и минимизировать участие других мышц. Регулярное выполнение сисси-приседаний помогает улучшить выносливость ног, повысить общую силу нижней части тела и улучшить технику приседаний.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            'Ноги' => 95,
            'Пресс' => 5,
        ];
        foreach ($muscles as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $weightedSissySquat->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Квадрицепс', 'Пресс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $weightedSissySquat->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная позиция корпуса: Держите спину прямой и корпус вертикальным, избегая наклона вперед или назад, чтобы максимально задействовать квадрицепсы.',
            'Контроль движения: Медленно опускайтесь вниз, контролируя движение, и поднимайтесь обратно, не используя инерцию или рывки.',
            'Поддержка баланса: Используйте опору (например, стену или специальную скамью) для поддержания равновесия, особенно при добавлении большого веса.',
            'Следите за коленями: Убедитесь, что колени следуют за направлением носков ног и не выходят слишком далеко вперед, чтобы избежать чрезмерной нагрузки на суставы.',
            'Начинайте с малого веса: Освойте технику без дополнительного веса или с минимальным отягощением, прежде чем постепенно увеличивать нагрузку для предотвращения травм.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $weightedSissySquat->tips()->attach($tip->id);
        }
        
        // Упражнение: Lever Seated Leg Extension
        $seatedLegExtension = Exercise::create([
            'name' => 'Сидячее разгибание ног на тренажере',
            'video_url' => '/video/exercises/Lever_Seated_Leg_Extension.mp4',
            'thumbnail_url' => '/images/thumbnail/Lever_Seated_Leg_Extension.jpg',
            'min_weight_male' => 40,
            'max_weight_male' => 140,
            'min_weight_female' => 20,
            'max_weight_female' => 100,
            'description' => 'Сидячее разгибание ног на тренажере — это изолирующее упражнение, направленное на развитие квадрицепсов, основных мышц передней части бедра. Выполняется на специальном тренажере, где пользователь сидит и поднимает вес, разгибая колени. Это упражнение способствует увеличению силы и массы квадрицепсов, улучшает эстетический вид ног и повышает функциональную силу нижних конечностей. Регулярное выполнение сидячих разгибаний ног помогает улучшить стабильность коленного сустава и общую выносливость ног.',
        ]);
        
        // Связь с мышцами
        $legs = MusclePercentage::where('name', 'Ноги')->first();
        if ($legs) {
            $seatedLegExtension->musclePercentages()->attach($legs->id, ['percentages' => 100]);
        }
        
        // Связь с фильтрами
        $filters = ['Квадрицепс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $seatedLegExtension->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная посадка: Убедитесь, что сиденье тренажера отрегулировано так, чтобы ось вращения колена совпадала с шарнирной частью тренажера. Спина должна быть плотно прижата к спинке сидения.',
            'Контролируемое движение: Медленно поднимайте вес, полностью разгибая колени, и плавно опускайте его обратно, избегая резких движений и раскачивания тела.',
            'Не блокируйте колени: В верхней точке движения держите колени слегка согнутыми, чтобы избежать чрезмерной нагрузки на суставы и связки.',
            'Дыхание: Вдыхайте при опускании веса и выдыхайте при подъеме, поддерживая ритмичное дыхание на протяжении всего упражнения.',
            'Фокус на квадрицепсах: Сосредоточьтесь на работе квадрицепсов, избегая использования импульса или других мышц для выполнения упражнения.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $seatedLegExtension->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Barbell Romanian Deadlift
        $romanianDeadlift = Exercise::create([
            'name' => 'Румынская становая тяга со штангой',
            'video_url' => '/video/exercises/Barbell_Romanian_Deadlift.mp4',
            'thumbnail_url' => '/images/thumbnail/Barbell_Romanian_Deadlift.jpg',
            'min_weight_male' => 40,
            'max_weight_male' => 160,
            'min_weight_female' => 20,
            'max_weight_female' => 80,
            'description' => 'Румынская становая тяга со штангой — это силовое упражнение, направленное на развитие задней цепи мышц, включая нижнюю часть спины, ягодицы и подколенные сухожилия. Выполняется с использованием штанги, при этом ноги остаются в слегка согнутом положении. Основное движение происходит за счет сгибания и разгибания бедер, что позволяет эффективно прорабатывать целевые группы мышц. Это упражнение способствует увеличению силы и выносливости мышц спины и ног, улучшает осанку и общую стабильность корпуса.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            'Спина' => 40,
            'Ноги' => 50,
            'Пресс' => 10,
        ];
        foreach ($muscles as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $romanianDeadlift->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Нижняя часть спины', 'Ягодицы', 'Подколенные сухожилия', 'Пресс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $romanianDeadlift->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная постановка спины: Держите спину прямой на протяжении всего упражнения, избегая округления или прогиба, чтобы снизить риск травм позвоночника.',
            'Движение бедрами: Фокусируйтесь на движении бедрами, а не на сгибании коленей. Бедра должны отводиться назад, сохраняя небольшую амплитуду сгиба в коленях.',
            'Контроль веса: Начинайте с легкого веса, постепенно увеличивая нагрузку по мере улучшения техники выполнения.',
            'Полная амплитуда: Опускайте штангу до уровня середины голени или до точки, где ощущается растяжение в подколенных сухожилиях, затем поднимайтесь, полностью разгибая бедра.',
            'Дыхание: Вдыхайте при опускании штанги и выдыхайте при подъеме, поддерживая ритмичное дыхание на протяжении всего упражнения.',
            'Удержание штанги: Держите штангу близко к телу, чтобы минимизировать нагрузку на поясницу и обеспечить более эффективную работу целевых мышц.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $romanianDeadlift->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Weighted Hyperextension
        $weightedHyperextension = Exercise::create([
            'name' => 'Гиперэкстензия с утяжелением',
            'video_url' => '/video/exercises/Weighted_Hyperextension.mp4',
            'thumbnail_url' => '/images/thumbnail/Weighted_Hyperextension.jpg',
            'min_weight_male' => 20,
            'max_weight_male' => 100,
            'min_weight_female' => 10,
            'max_weight_female' => 60,
            'description' => 'Гиперэкстензия с утяжелением — это упражнение, направленное на укрепление мышц нижней части спины, ягодиц и подколенных сухожилий. Выполняется на специальной скамье для гиперэкстензий, где спортсмен закрепляет утяжеление (например, держит диск или использует пояс с весами) на плечах. Во время выполнения упражнения необходимо контролировать движение, поднимая верхнюю часть тела до выпрямленного положения и медленно опускаясь обратно. Регулярное выполнение гиперэкстензий способствует улучшению осанки, увеличению силы и выносливости мышц спины, а также снижению риска травм поясничного отдела позвоночника.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            'Спина' => 70,
            'Ноги' => 20,
            'Пресс' => 10,
        ];
        foreach ($muscles as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $weightedHyperextension->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Нижняя часть спины', 'Подколенные сухожилия', 'Ягодицы'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $weightedHyperextension->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная техника: Держите спину ровной и избегайте чрезмерного прогиба или округления позвоночника. Движение должно быть контролируемым как при подъеме, так и при опускании.',
            'Активизация мышц кора: Напрягайте мышцы пресса и ягодиц на протяжении всего упражнения для дополнительной стабилизации корпуса.',
            'Выбор подходящего веса: Начинайте с небольших весов, постепенно увеличивая нагрузку по мере укрепления мышц. Не перегружайте себя, чтобы избежать травм.',
            'Дыхание: Вдыхайте при опускании тела и выдыхайте при подъеме. Поддерживайте ритмичное дыхание для оптимальной эффективности упражнения.',
            'Контроль амплитуды: Выполняйте упражнение через полный диапазон движений, но не переходите за пределы комфортной амплитуды, чтобы сохранить безопасность и эффективность тренировки.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $weightedHyperextension->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Barbell Good Morning
        $barbellGoodMorning = Exercise::create([
            'name' => 'Гуд Морнинг со штангой',
            'video_url' => '/video/exercises/Barbell_Good_Morning.mp4',
            'thumbnail_url' => '/images/thumbnail/Barbell_Good_Morning.jpg',
            'min_weight_male' => 40,
            'max_weight_male' => 120,
            'min_weight_female' => 20,
            'max_weight_female' => 60,
            'description' => 'Гуд Морнинг со штангой — это упражнение, направленное на развитие нижней части спины, подколенных сухожилий и ягодичных мышц. Выполняется с использованием штанги, которая размещается на трапециевидных мышцах. Упражнение способствует укреплению мышц задней цепи, улучшению осанки и повышению общей силы корпуса.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            ['name' => 'Спина', 'percentage' => 60],
            ['name' => 'Ноги', 'percentage' => 35],
            ['name' => 'Пресс', 'percentage' => 5]
        ];
        foreach ($muscles as $muscleData) {
            $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
            if ($muscle) {
                $barbellGoodMorning->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentage']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Нижняя часть спины', 'Подколенные сухожилия', 'Ягодицы', 'Пресс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $barbellGoodMorning->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная постановка штанги: Разместите штангу на трапециевидных мышцах, избегая давления на шею. Держите руки крепко, но не перенапрягайте предплечья.',
            'Сохранение нейтральной спины: Поддерживайте прямую линию позвоночника на протяжении всего упражнения, избегая прогиба или округления спины.',
            'Контролируемое движение: Наклоняйтесь вперед из бедер, а не из талии, пока корпус не станет параллелен полу или чуть ниже, затем медленно возвращайтесь в исходное положение.',
            'Активизация ягодиц и подколенных сухожилий: Сфокусируйтесь на работе задней цепи, активно задействуя ягодичные мышцы и подколенные сухожилия при подъеме.',
            'Дыхание: Вдыхайте при наклоне вперед и выдыхайте при возвращении в исходное положение, поддерживая стабильное и ритмичное дыхание.',
            'Использование зеркала: Выполняйте упражнение перед зеркалом, чтобы контролировать технику и избегать ошибок в постановке спины.',
            'Начинайте с легкого веса: Освойте технику без дополнительного веса или с минимальной нагрузкой, постепенно увеличивая вес по мере укрепления мышц и улучшения формы выполнения.'
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $barbellGoodMorning->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Barbell Straight Leg Deadlift
        $barbellStraightLegDeadlift = Exercise::create([
            'name' => 'Становая тяга на прямых ногах',
            'video_url' => '/video/exercises/Barbell_Straight_Leg_Deadlift.mp4',
            'thumbnail_url' => '/images/thumbnail/Barbell_Straight_Leg_Deadlift.jpg',
            'min_weight_male' => 40,
            'max_weight_male' => 160,
            'min_weight_female' => 20,
            'max_weight_female' => 80,
            'description' => 'Становая тяга на прямых ногах — это базовое силовое упражнение, направленное на развитие нижней части спины, подколенных сухожилий и ягодиц. Выполняется с использованием штанги, которую опускают и поднимают с прямыми ногами, сохраняя нейтральное положение позвоночника.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            ['name' => 'Спина', 'percentage' => 50],
            ['name' => 'Ноги', 'percentage' => 35],
            ['name' => 'Пресс', 'percentage' => 15]
        ];
        foreach ($muscles as $muscleData) {
            $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
            if ($muscle) {
                $barbellStraightLegDeadlift->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentage']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Нижняя часть спины', 'Подколенные сухожилия', 'Широчайшие', 'Пресс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $barbellStraightLegDeadlift->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная техника: Держите спину прямой, избегайте прогиба или округления позвоночника во время выполнения упражнения.',
            'Контроль амплитуды: Опускайте штангу до уровня середины голени или ниже, сохраняя легкое сгибание в коленях.',
            'Постепенное увеличение веса: Начинайте с легких весов, постепенно увеличивая нагрузку по мере улучшения техники и силы.',
            'Активное дыхание: Вдыхайте при опускании штанги и выдыхайте при подъеме, поддерживая стабильное дыхание.',
            'Использование пояса: Для дополнительной поддержки спины используйте поясничный пояс, особенно при работе с большими весами.'
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $barbellStraightLegDeadlift->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Barbell Pendlay Row
        $pendlayRow = Exercise::create([
            'name' => 'Пендлейская тяга штанги',
            'video_url' => '/video/exercises/Barbell_Pendlay_Row.mp4',
            'thumbnail_url' => '/images/thumbnail/Barbell_Pendlay_Row.jpg',
            'min_weight_male' => 50,
            'max_weight_male' => 140,
            'min_weight_female' => 30,
            'max_weight_female' => 80,
            'description' => 'Пендлейская тяга штанги — это силовое упражнение, направленное на развитие мышц спины, особенно широчайших, трапеций и бицепсов. Выполняется с акцентом на строгую технику, начиная с полного покоя на полу между подходами. Это позволяет изолировать мышцы спины и минимизировать использование инерции, повышая эффективность нагрузки. Упражнение способствует увеличению силы и массы верхней части тела, улучшению осанки и общей функциональной силы.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            ['name' => 'Спина', 'percentage' => 60],
            ['name' => 'Руки', 'percentage' => 25],
            ['name' => 'Плечи', 'percentage' => 10],
            ['name' => 'Пресс', 'percentage' => 5],
        ];
        foreach ($muscles as $muscleData) {
            $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
            if ($muscle) {
                $pendlayRow->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentage']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Широчайшие', 'Трапеции', 'Бицепс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $pendlayRow->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Держите спину ровной и параллельной полу, избегайте округления или чрезмерного прогиба в пояснице.',
            'Захват штанги должен быть на ширине плеч или чуть уже, ладони могут быть направлены вперед или вниз.',
            'Тяните штангу к нижней части грудной клетки, затем опускайте её медленно и контролируемо до полного покоя на полу.',
            'Не используйте инерцию или резкие движения; сосредоточьтесь на сокращении мышц спины при каждом повторении.',
            'Вдыхайте при опускании штанги и выдыхайте при тяге, поддерживая ритмичное дыхание на протяжении всего упражнения.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $pendlayRow->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Glute Ham Raise
        $gluteHamRaise = Exercise::create([
            'name' => 'Подъем ягодиц и бицепсов бедра',
            'video_url' => '/video/exercises/Glute_Ham_Raise.mp4',
            'thumbnail_url' => '/images/thumbnail/Glute_Ham_Raise.jpg',
            'min_weight_male' => 20,
            'max_weight_male' => 100,
            'min_weight_female' => 10,
            'max_weight_female' => 50,
            'description' => 'Подъем ягодиц и бицепсов бедра — это упражнение, нацеленное на развитие задней цепи мышц, включая подколенные сухожилия, ягодицы и нижнюю часть спины. Выполняется на специальной скамье для глюте-хэм-рейзов или с использованием оборудования, обеспечивающего устойчивость тела. Упражнение способствует увеличению силы и массы мышц задней поверхности бедра и ягодиц, улучшая общую силу и стабильность нижней части тела. Регулярное выполнение подъемов ягодиц и бицепсов бедра помогает предотвратить травмы, улучшить осанку и повысить спортивные показатели.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            ['name' => 'Ноги', 'percentage' => 60],
            ['name' => 'Спина', 'percentage' => 30],
            ['name' => 'Пресс', 'percentage' => 10],
        ];
        foreach ($muscles as $muscleData) {
            $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
            if ($muscle) {
                $gluteHamRaise->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentage']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Подколенные сухожилия', 'Ягодицы', 'Нижняя часть спины'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $gluteHamRaise->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Убедитесь, что бедра закреплены в специальной валику или оборудовании, чтобы избежать прогибов и обеспечить изоляцию задней цепи мышц.',
            'Медленно опускайтесь вниз, контролируя движение, чтобы максимально задействовать подколенные сухожилия и ягодицы, затем поднимайтесь с максимальной силой.',
            'Поддерживайте прямую линию от головы до пяток, избегая раскачивания таза, чтобы минимизировать нагрузку на нижнюю часть спины.',
            'Вдыхайте при опускании тела вниз и выдыхайте при подъеме, поддерживая ритмичное дыхание на протяжении всего упражнения.',
            'Опускайтесь как можно ниже, сохраняя контроль, и полностью выпрямляйте тело в верхней точке для максимальной эффективности упражнения.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $gluteHamRaise->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Trap Bar Deadlift
        $trapBarDeadlift = Exercise::create([
            'name' => 'Становая тяга с трап-баром',
            'video_url' => '/video/exercises/Trap_Bar_Deadlift.mp4',
            'thumbnail_url' => '/images/thumbnail/Trap_Bar_Deadlift.jpg',
            'min_weight_male' => 60,
            'max_weight_male' => 180,
            'min_weight_female' => 30,
            'max_weight_female' => 100,
            'description' => 'Становая тяга с трап-баром — это упражнение, выполняемое с использованием трап-бара, которое позволяет более равномерно распределить нагрузку между ногами и спиной по сравнению с традиционной становой тягой. Это упражнение направлено на развитие мышц спины, ног и пресса, а также улучшение общей силы и стабильности. Становая тяга с трап-баром также снижает нагрузку на нижнюю часть спины, делая её более безопасной для выполнения по сравнению с другими видами становых тяг.',
        ]);
        
        // Связь с мышцами
        $musclePercentages = [
            'Спина' => 40,
            'Ноги' => 50,
            'Пресс' => 10,
        ];
        foreach ($musclePercentages as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $trapBarDeadlift->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Широчайшие', 'Квадрицепс', 'Ягодицы', 'Подколенные сухожилия', 'Нижняя часть спины', 'Пресс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $trapBarDeadlift->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная постановка ног: Расположите ноги на ширине плеч, ступни слегка развернуты наружу для оптимальной стабильности.',
            'Держите спину прямо: Во время выполнения упражнения сохраняйте нейтральное положение спины, избегайте её прогиба или округления.',
            'Используйте полный диапазон движений: Опускайтесь до тех пор, пока бедра не будут параллельны полу, и полностью выпрямляйте тело при подъёме.',
            'Активируйте мышцы кора: Напрягите пресс и стабилизируйте корпус, чтобы обеспечить дополнительную поддержку спины и предотвратить травмы.',
            'Контролируйте движение: Поднимайте и опускайте трап-бар плавно и контролируемо, избегая рывков и чрезмерной скорости.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $trapBarDeadlift->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Dumbbell Reverse Hyperextension on Bench
        $dumbbellReverseHyperextension = Exercise::create([
            'name' => 'Обратная гиперэкстензия с гантелями на скамье',
            'video_url' => '/video/exercises/Dumbbell_Reverse_Hyperextension_on_Bench.mp4',
            'thumbnail_url' => '/images/thumbnail/Dumbbell_Reverse_Hyperextension_on_Bench.jpg',
            'min_weight_male' => 20,
            'max_weight_male' => 100,
            'min_weight_female' => 10,
            'max_weight_female' => 60,
            'description' => 'Обратная гиперэкстензия с гантелями на скамье — это упражнение, направленное на развитие мышц нижней части спины, ягодиц и подколенных сухожилий. Выполняется лежа лицом вниз на скамье с гантелей, удерживаемой между стопами или бедрами. При выполнении упражнения ноги поднимаются назад и вверх, что способствует укреплению задней цепи мышц, улучшению стабильности нижней части спины и повышению общей физической выносливости. Регулярное выполнение этого упражнения помогает предотвратить травмы спины и улучшить спортивные показатели.',
        ]);
        
        // Связь с мышцами
        $musclePercentages = [
            'Спина' => 50,
            'Ноги' => 40,
            'Пресс' => 10,
        ];
        foreach ($musclePercentages as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $dumbbellReverseHyperextension->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Нижняя часть спины', 'Ягодицы', 'Подколенные сухожилия', 'Пресс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $dumbbellReverseHyperextension->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильное положение тела: Лягте лицом вниз на скамью, удерживая гантель между стопами или внизу бедер. Убедитесь, что спина остаётся ровной и не прогибается.',
            'Контроль движения: Поднимайте ноги медленно и контролируемо, избегая рывков. Максимально сокращайте мышцы спины и ягодиц в верхней точке.',
            'Дыхание: Вдыхайте при опускании ног и выдыхайте при подъеме, поддерживая ритмичное дыхание на протяжении всего упражнения.',
            'Избегайте чрезмерной нагрузки: Начинайте с меньших весов, чтобы избежать перенапряжения нижней части спины. Постепенно увеличивайте вес по мере улучшения силы и техники.',
            'Стабильная спина: Держите спину в нейтральном положении, избегая чрезмерного прогиба или округления для предотвращения травм.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $dumbbellReverseHyperextension->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Barbell Standing Military Press
        $militaryPress = Exercise::create([
            'name' => 'Жим штанги стоя',
            'video_url' => '/video/exercises/Barbell_Standing_Military_Press.mp4',
            'thumbnail_url' => '/images/thumbnail/Barbell_Standing_Military_Press.jpg',
            'min_weight_male' => 40,
            'max_weight_male' => 100,
            'min_weight_female' => 20,
            'max_weight_female' => 60,
            'description' => 'Жим штанги стоя — это базовое упражнение для развития мышц плечевого пояса. Оно направлено на укрепление дельтовидных мышц, трицепсов и верхней части спины. Упражнение выполняется стоя, что требует хорошей стабилизации корпуса и развивает силу и выносливость верхней части тела. Регулярное выполнение жима штанги стоя способствует улучшению общей силы плеч и помогает в выполнении различных спортивных и повседневных задач.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            ['name' => 'Плечи', 'percentage' => 70],
            ['name' => 'Руки', 'percentage' => 30],
        ];
        foreach ($muscles as $muscleData) {
            $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
            if ($muscle) {
                $militaryPress->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentage']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Плечи', 'Трицепс', 'Верхняя часть спины'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $militaryPress->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная стойка: Встаньте прямо, ноги на ширине плеч, немного согнув колени для стабильности.',
            'Положение рук: Держите штангу на уровне плеч, руки чуть шире плеч, локти под углом примерно 45 градусов к корпусу.',
            'Контроль движения: Поднимайте штангу вверх, полностью выпрямляя руки, не разогибая локти полностью в верхней точке.',
            'Стабильный корпус: Держите спину прямой и напряжённой, избегайте раскачивания или прогиба спины во время выполнения упражнения.',
            'Дыхание: Вдыхайте при опускании штанги и выдыхайте при её подъёме, поддерживая ритмичное дыхание на протяжении всего подхода.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $militaryPress->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Dumbbell Seated Shoulder Press
        $shoulderPress = Exercise::create([
            'name' => 'Жим гантелей сидя',
            'video_url' => '/video/exercises/Dumbbell_Seated_Shoulder_Press.mp4',
            'thumbnail_url' => '/images/thumbnail/Dumbbell_Seated_Shoulder_Press.jpg',
            'min_weight_male' => 20,
            'max_weight_male' => 100,
            'min_weight_female' => 10,
            'max_weight_female' => 70,
            'description' => 'Жим гантелей сидя — это упражнение, направленное на развитие плечевых мышц, особенно дельтовидных, а также трицепсов и верхней части грудных мышц. Выполняется в положении сидя на скамье с опорой спины, что помогает стабилизировать тело и изолировать нагрузку на плечи. Жим гантелей сидя способствует увеличению силы и массы плеч, улучшению общей верхней части тела и повышению функциональной выносливости.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            ['name' => 'Плечи', 'percentage' => 70],
            ['name' => 'Руки', 'percentage' => 20],
            ['name' => 'Грудь', 'percentage' => 10],
        ];
        foreach ($muscles as $muscleData) {
            $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
            if ($muscle) {
                $shoulderPress->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentage']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Плечи', 'Трицепс', 'Грудь'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $shoulderPress->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная посадка: Сидите на скамье с прямой спиной, стопы плотно стоят на полу. Убедитесь, что ваша спина полностью поддерживается спинкой скамьи, чтобы избежать раскачивания.',
            'Положение рук: Держите гантели на уровне плеч, ладони направлены вперёд. Локти слегка согнуты, чтобы минимизировать нагрузку на суставы.',
            'Контроль движения: Поднимайте гантели вверх до полного выпрямления рук, не блокируя локтевые суставы. Медленно опускайте гантели обратно до уровня плеч, контролируя движение на протяжении всего упражнения.',
            'Дыхание: Вдыхайте при опускании гантелей и выдыхайте при подъёме, поддерживая ритмичное дыхание.',
            'Амплитуда движений: Выполняйте упражнение через полный диапазон движений для максимальной эффективности. Избегайте чрезмерного наклона или прогиба спины.',
            'Безопасность: Начинайте с более лёгких весов, чтобы освоить технику, и постепенно увеличивайте нагрузку. Не допускайте резких движений, чтобы избежать травм плечевых суставов и спины.',
            'Стабилизация корпуса: Напрягайте мышцы кора для стабилизации тела и предотвращения раскачивания, что поможет изолировать нагрузку на плечи и трицепсы.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $shoulderPress->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Dumbbell Arnold Press
        $dumbbellArnoldPress = Exercise::create([
            'name' => 'Жим Арнольда с гантелями',
            'video_url' => '/video/exercises/Dumbbell_Arnold_Press.mp4',
            'thumbnail_url' => '/images/thumbnail/Dumbbell_Arnold_Press.jpg',
            'min_weight_male' => 10,
            'max_weight_male' => 40,
            'min_weight_female' => 5,
            'max_weight_female' => 20,
            'description' => 'Жим Арнольда с гантелями — это вариация классического жима гантелей, названная в честь легендарного бодибилдера Арнольда Шварценеггера. Это упражнение нацелено на развитие передних и средних дельтовидных мышц, а также активно вовлекает бицепсы и трицепсы. Жим Арнольда способствует улучшению подвижности плечевого сустава и общей силы верхней части тела. В отличие от стандартного жима, выполнение вращения кистей во время подъема обеспечивает более полный проработку мышц плеч, повышая их объем и силу.',
        ]);
        
        // Связь с мышцами
        $musclePercentagesArnold = [
            ['name' => 'Плечи', 'percentage' => 60],
            ['name' => 'Руки', 'percentage' => 30],
            ['name' => 'Грудь', 'percentage' => 10],
        ];
        foreach ($musclePercentagesArnold as $muscle) {
            $muscleEntity = MusclePercentage::where('name', $muscle['name'])->first();
            if ($muscleEntity) {
                $dumbbellArnoldPress->musclePercentages()->attach($muscleEntity->id, ['percentages' => $muscle['percentage']]);
            }
        }
        
        // Связь с фильтрами
        $filtersArnold = ['Плечи', 'Трицепс', 'Бицепс'];
        foreach ($filtersArnold as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $dumbbellArnoldPress->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tipsArnold = [
            'Правильная позиция рук: Начинайте с гантелями перед плечами, кисти направлены к себе. Во время подъема вращайте кисти наружу, заканчивая движением с ладонями вперед.',
            'Контроль движения: Поднимайте гантели плавно и без рывков, концентрируясь на работе плечевых мышц. Избегайте использования инерции для подъема веса.',
            'Стабильный корпус: Держите спину прямой и избегайте прогибов в пояснице. Напрягите мышцы кора для поддержания стабильности во время выполнения упражнения.',
            'Дыхание: Вдыхайте при опускании гантелей и выдыхайте при подъеме, поддерживая ритмичное дыхание на протяжении всего упражнения.',
            'Полный диапазон движений: Выполняйте упражнение через полный диапазон движений, чтобы обеспечить максимальную эффективность и развитие мышц плеч.',
        ];
        foreach ($tipsArnold as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $dumbbellArnoldPress->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Lever Seated Shoulder Press
        $leverShoulderPress = Exercise::create([
            'name' => 'Жим плеч на тренажере сидя',
            'video_url' => '/video/exercises/Lever_Seated_Shoulder_Press.mp4',
            'thumbnail_url' => '/images/thumbnail/Lever_Seated_Shoulder_Press.jpg',
            'min_weight_male' => 20,
            'max_weight_male' => 100,
            'min_weight_female' => 10,
            'max_weight_female' => 50,
            'description' => 'Жим плеч на тренажере сидя — это упражнение, направленное на развитие дельтовидных мышц плечевого пояса. Выполняется на специальном тренажере, что позволяет стабилизировать тело и сосредоточиться на работе плеч. Это упражнение способствует увеличению силы и массы плеч, улучшая общую силу верхней части тела и поддерживая правильную осанку. Также жим плеч на тренажере сидя вовлекает трицепсы и верхнюю часть грудных мышц, обеспечивая комплексную нагрузку на верхнюю часть тела.',
        ]);
        
        // Связь с мышцами
        $musclePercentagesLever = [
            ['name' => 'Плечи', 'percentage' => 60],
            ['name' => 'Руки', 'percentage' => 25],
            ['name' => 'Грудь', 'percentage' => 15],
        ];
        foreach ($musclePercentagesLever as $muscle) {
            $muscleEntity = MusclePercentage::where('name', $muscle['name'])->first();
            if ($muscleEntity) {
                $leverShoulderPress->musclePercentages()->attach($muscleEntity->id, ['percentages' => $muscle['percentage']]);
            }
        }
        
        // Связь с фильтрами
        $filtersLever = ['Плечи', 'Трицепс', 'Грудь'];
        foreach ($filtersLever as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $leverShoulderPress->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tipsLever = [
            'Правильная посадка: Сядьте прямо на тренажер, установите спинку и подлокотники так, чтобы ваши локти были на уровне плеч и могли двигаться свободно.',
            'Удержание веса: Держите рукоятки тренажера надежно, но не зажимайте их слишком сильно, чтобы избежать излишнего напряжения в кистях.',
            'Контроль движения: Медленно выжимайте вес вверх, полностью выпрямляя руки без замыкания локтей, затем плавно опускайте вес до уровня плеч.',
            'Дыхание: Вдыхайте при опускании веса и выдыхайте при его подъеме, поддерживая ритмичное дыхание на протяжении всего упражнения.',
            'Избегайте раскачивания: Держите корпус стабильно и избегайте наклонов вперед или назад, чтобы максимально изолировать нагрузку на плечи и минимизировать риск травм.',
        ];
        foreach ($tipsLever as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $leverShoulderPress->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Cable Lateral Raise
        $cableLateralRaise = Exercise::create([
            'name' => 'Разведение рук в стороны на блоке',
            'video_url' => '/video/exercises/Cable_Lateral_Raise.mp4',
            'thumbnail_url' => '/images/thumbnail/Cable_Lateral_Raise.jpg',
            'min_weight_male' => 10,
            'max_weight_male' => 50,
            'min_weight_female' => 5,
            'max_weight_female' => 30,
            'description' => 'Разведение рук в стороны на блоке — это упражнение, направленное на развитие средних дельтовидных мышц плечевого пояса. Выполняется с использованием тренажёра с кабелем, что обеспечивает постоянное сопротивление на протяжении всего движения. Это упражнение помогает улучшить форму и ширину плеч, способствует симметрии верхней части тела и укрепляет стабилизирующие мышцы плечевого сустава.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            ['name' => 'Плечи', 'percentage' => 80],
            ['name' => 'Спина', 'percentage' => 20]
        ];
        foreach ($muscles as $muscleData) {
            $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
            if ($muscle) {
                $cableLateralRaise->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentage']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Плечи', 'Трапеции', 'Предплечья'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $cableLateralRaise->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Держите спину прямой и слегка наклонитесь вперёд.',
            'Выполняйте упражнение медленно и контролируемо.',
            'Поднимайте руки до уровня плеч и опускайте их полностью.',
            'Слегка согните локти для снижения нагрузки на суставы.',
            'Вдыхайте при опускании и выдыхайте при подъёме рук.',
            'Поддерживайте постоянное напряжение в мышцах.',
            'Используйте такой вес, который позволяет сохранять правильную технику.'
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $cableLateralRaise->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Dumbbell Standing Lateral Raise
        $dumbbellLateralRaise = Exercise::create([
            'name' => 'Разведение гантелей в стороны стоя',
            'video_url' => '/video/exercises/Dumbbell_Standing_Lateral_Raise.mp4',
            'thumbnail_url' => '/images/thumbnail/Dumbbell_Standing_Lateral_Raise.jpg',
            'min_weight_male' => 10,
            'max_weight_male' => 30,
            'min_weight_female' => 5,
            'max_weight_female' => 20,
            'description' => 'Разведение гантелей в стороны стоя — это упражнение, направленное на развитие средних дельтовидных мышц плеч. Выполняется стоя с гантелями в руках, которые поднимаются в стороны до уровня плеч.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            ['name' => 'Плечи', 'percentage' => 70],
            ['name' => 'Ноги', 'percentage' => 20],
            ['name' => 'Руки', 'percentage' => 10]
        ];
        foreach ($muscles as $muscleData) {
            $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
            if ($muscle) {
                $dumbbellLateralRaise->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentage']]);
            }
        }
        
        // Связь с фильтрами
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $dumbbellLateralRaise->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Держите спину прямой, ноги на ширине плеч.',
            'Поднимайте гантели медленно и контролируемо.',
            'Локти слегка согнуты, руки поднимаются до уровня плеч.',
            'Вдыхайте при опускании гантелей и выдыхайте при их подъёме.',
            'Сосредоточьтесь на сокращении дельтовидных мышц.'
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $dumbbellLateralRaise->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Dumbbell Front Raise
        $dumbbellFrontRaise = Exercise::create([
            'name' => 'Подъем гантелей перед собой',
            'video_url' => '/video/exercises/Dumbbell_Front_Raise.mp4',
            'thumbnail_url' => '/images/thumbnail/Dumbbell_Front_Raise.jpg',
            'min_weight_male' => 10,
            'max_weight_male' => 30,
            'min_weight_female' => 5,
            'max_weight_female' => 20,
            'description' => 'Подъем гантелей перед собой — это упражнение, направленное на развитие передних дельтовидных мышц плеч. Оно выполняется с использованием гантелей, которые поднимаются вперед до уровня глаз или чуть выше. Упражнение помогает укрепить и сформировать переднюю часть плечевого пояса, улучшить осанку и повысить общую силу верхней части тела. Регулярное выполнение подъемов гантелей перед собой способствует лучшей симметрии плеч и увеличению функциональной силы для других упражнений и повседневных движений.',
        ]);
        
        // Связь с мышцами
        $musclePercentages = [
            ['name' => 'Плечи', 'percentages' => 80],
            ['name' => 'Руки', 'percentages' => 10],
            ['name' => 'Пресс', 'percentages' => 10],
        ];
        foreach ($musclePercentages as $muscleData) {
            $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
            if ($muscle) {
                $dumbbellFrontRaise->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Плечи', 'Бицепс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $dumbbellFrontRaise->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Держите спину прямой, ноги на ширине плеч. Избегайте раскачивания тела и фиксации локтей слегка согнутыми для минимизации нагрузки на суставы.',
            'Поднимайте гантели медленно и плавно, концентрируясь на сокращении передних дельтовидных мышц. Опускайте гантели контролируемо, не позволяя им свободно падать.',
            'Выполняйте полный диапазон движений, поднимая гантели до уровня глаз или чуть выше и полностью опуская их вниз, чтобы обеспечить максимальную эффективность упражнения.',
            'Вдыхайте при опускании гантелей и выдыхайте при подъеме, поддерживая ритмичное дыхание на протяжении всего подхода.',
            'Начинайте с легких гантелей, чтобы освоить технику, и постепенно увеличивайте вес по мере увеличения силы и выносливости мышц.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $dumbbellFrontRaise->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Cable Standing Face Pull
        $cableStandingFacePull = Exercise::create([
            'name' => 'Тяга к лицу на блоке стоя',
            'video_url' => '/video/exercises/Cable_Standing_Face_Pull.mp4',
            'thumbnail_url' => '/images/thumbnail/Cable_Standing_Face_Pull.jpg',
            'min_weight_male' => 20,
            'max_weight_male' => 60,
            'min_weight_female' => 10,
            'max_weight_female' => 40,
            'description' => 'Тяга к лицу на блоке стоя — это упражнение, направленное на развитие задних дельтовидных мышц, трапеций и верхней части спины. Выполняется с использованием троса на блочном тренажёре, где вы тянете рукоять к лицу, удерживая локти на уровне плеч. Это упражнение помогает улучшить осанку, укрепить мышцы плеч и спины, а также способствует балансированию развитости передней и задней части плеч.',
        ]);
        
        // Связь с мышцами
        $musclePercentages = [
            ['name' => 'Плечи', 'percentages' => 50],
            ['name' => 'Спина', 'percentages' => 40],
            ['name' => 'Руки', 'percentages' => 10],
        ];
        foreach ($musclePercentages as $muscleData) {
            $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
            if ($muscle) {
                $cableStandingFacePull->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Плечи', 'Верхняя часть спины', 'Трапеции', 'Бицепс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $cableStandingFacePull->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Держите спину прямой и избегайте раскачивания тела, чтобы сосредоточить нагрузку на плечах и спине.',
            'Тяните трос к лицу медленно и контролируемо, фокусируясь на сокращении задних дельтов и трапеций.',
            'Держите локти на уровне плеч или чуть выше, не опуская их вниз, чтобы максимально задействовать целевые мышцы.',
            'Выполняйте упражнение через полный диапазон, полностью растягивая мышцы в начальной точке и полностью сокращая в конце движения.',
            'Вдыхайте при возвращении в исходное положение и выдыхайте при тяге троса к лицу, поддерживая стабильное дыхание.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $cableStandingFacePull->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Cable Incline Rear Delt Fly
        $cableInclineRearDeltFly = Exercise::create([
            'name' => 'Разводка задних дельт с кабелями на наклонной скамье',
            'video_url' => '/video/exercises/Cable_Incline_Rear_Delt_Fly.mp4',
            'thumbnail_url' => '/images/thumbnail/Cable_Incline_Rear_Delt_Fly.jpg',
            'min_weight_male' => 30,
            'max_weight_male' => 70,
            'min_weight_female' => 10,
            'max_weight_female' => 30,
            'description' => 'Разводка задних дельт с кабелями на наклонной скамье — это упражнение, направленное на развитие задних дельтовидных мышц, верхней части спины и трапеций. Выполняется на наклонной скамье с использованием кабельного тренажера, что обеспечивает постоянное натяжение мышц на протяжении всего движения. Это упражнение помогает улучшить силу и форму плеч, способствует улучшению осанки и баланса верхней части тела, а также повышает общую функциональную выносливость.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            ['name' => 'Плечи', 'percentages' => 60],
            ['name' => 'Спина', 'percentages' => 40],
        ];
        foreach ($muscles as $muscleData) {
            $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
            if ($muscle) {
                $cableInclineRearDeltFly->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Плечи', 'Верхняя часть спины', 'Трапеции', 'Предплечья'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $cableInclineRearDeltFly->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная позиция тела: Установите наклонную скамью под углом около 45 градусов, держите спину прямо и стабильно, чтобы изолировать работу задних дельтов.',
            'Контроль движения: Выполняйте разводку медленно и контролируемо, избегая рывков и чрезмерного отклонения рук за уровень плеч.',
            'Локти слегка согнуты: Держите локти слегка согнутыми на протяжении всего упражнения, чтобы минимизировать нагрузку на суставы и максимизировать работу мышц.',
            'Полный диапазон движений: Расведите руки полностью в стороны и медленно верните их в исходное положение, обеспечивая полное сокращение и растяжение мышц.',
            'Дыхание: Вдыхайте при разведение рук и выдыхайте при их возвращении, поддерживая ритмичное дыхание для стабильности и эффективности выполнения упражнения.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $cableInclineRearDeltFly->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Dumbbell Rear Delt Fly
        $dumbbellRearDeltFly = Exercise::create([
            'name' => 'Разводка гантелей для задних дельт',
            'video_url' => '/video/exercises/Dumbbell_Rear_Delt_Fly.mp4',
            'thumbnail_url' => '/images/thumbnail/Dumbbell_Rear_Delt_Fly.jpg',
            'min_weight_male' => 10,
            'max_weight_male' => 35,
            'min_weight_female' => 5,
            'max_weight_female' => 25,
            'description' => 'Разводка гантелей для задних дельт — это изолирующее упражнение, направленное на развитие задних дельтовидных мышц плеч. Выполняется с гантелями в наклонном положении или сидя, что позволяет максимально сфокусироваться на целевых мышцах без излишней нагрузки на спину. Это упражнение помогает улучшить баланс мышц плечевого пояса, повысить общую силу плеч и улучшить осанку, предотвращая развитие мышечного дисбаланса.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            ['name' => 'Плечи', 'percentages' => 60],
            ['name' => 'Спина', 'percentages' => 30],
            ['name' => 'Руки', 'percentages' => 10],
        ];
        foreach ($muscles as $muscleData) {
            $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
            if ($muscle) {
                $dumbbellRearDeltFly->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Плечи', 'Трапеции', 'Верхняя часть спины'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $dumbbellRearDeltFly->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная техника: Держите спину прямой и слегка наклонитесь вперёд, чтобы изолировать задние дельты. Не используйте инерцию для подъёма гантелей.',
            'Контроль движения: Поднимайте гантели медленно и контролируемо, концентрируясь на сокращении задних дельтов. Избегайте резких движений.',
            'Положение рук: Локти должны быть слегка согнуты, а руки двигаться в стороны на уровне плеч, не поднимая гантели выше этой линии.',
            'Дыхание: Вдыхайте при опускании гантелей и выдыхайте при подъёме, поддерживая ритмичное дыхание.',
            'Выбор веса: Начинайте с более лёгких гантелей, чтобы освоить технику, постепенно увеличивая вес по мере роста силы и выносливости.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $dumbbellRearDeltFly->tips()->attach($tip->id);
        }
        
        // Упражнение: Kettlebell Seated Two Arm Military Press
        $kettlebellPress = Exercise::create([
            'name' => 'Сидячий армейский жим двумя гирями',
            'video_url' => '/video/exercises/Kettlebell_Seated_Two_Arm_Military_Press.mp4',
            'thumbnail_url' => '/images/thumbnail/Kettlebell_Seated_Two_Arm_Military_Press.jpg',
            'min_weight_male' => 12,
            'max_weight_male' => 32,
            'min_weight_female' => 8,
            'max_weight_female' => 24,
            'description' => 'Сидячий армейский жим двумя гирями — это силовое упражнение, направленное на развитие плечевых мышц, особенно дельтовидных, а также трицепсов и грудных мышц. Выполняется в сидячем положении с гирями, что обеспечивает стабильность и изолирует нагрузку на верхнюю часть тела. Упражнение способствует увеличению силы и массы плеч, улучшает баланс и координацию движений верхней части тела, а также помогает развивать выносливость мышц рук и груди.',
        ]);
        
        // Связь с мышцами
        $muscleGroups = [
            ['name' => 'Плечи', 'percentage' => 70],
            ['name' => 'Руки', 'percentage' => 20],
            ['name' => 'Грудь', 'percentage' => 10],
        ];
        foreach ($muscleGroups as $muscle) {
            $muscleRecord = MusclePercentage::where('name', $muscle['name'])->first();
            if ($muscleRecord) {
                $kettlebellPress->musclePercentages()->attach($muscleRecord->id, ['percentages' => $muscle['percentage']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Плечи', 'Трицепс', 'Грудь'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $kettlebellPress->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная посадка: Сядьте на скамью с прямой спиной, стопы устойчиво стоят на полу, плечи отведены назад для стабильности.',
            'Контроль движения: Поднимайте гири плавно и контролируемо, избегая резких рывков, чтобы минимизировать риск травм.',
            'Положение локтей: Держите локти под углом примерно 90 градусов при опускании гирь, чтобы эффективно задействовать дельтовидные мышцы.',
            'Дыхание: Вдыхайте при опускании гирь и выдыхайте при их подъеме, поддерживая ритмичное дыхание на протяжении всего подхода.',
            'Минимизация раскачивания: Держите корпус стабильным и избегайте раскачивания, чтобы сосредоточить нагрузку на плечах и трицепсах.'
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $kettlebellPress->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Lever Lying Leg Curl
        $leverLyingLegCurl = Exercise::create([
            'name' => 'Сгибание ног на наклонной скамье в тренажёре',
            'video_url' => '/video/exercises/Lever_Lying_Leg_Curl.mp4',
            'thumbnail_url' => '/images/thumbnail/Lever_Lying_Leg_Curl.jpg',
            'min_weight_male' => 40,
            'max_weight_male' => 100,
            'min_weight_female' => 20,
            'max_weight_female' => 60,
            'description' => 'Сгибание ног на наклонной скамье в тренажёре — это упражнение, направленное на развитие подколенных сухожилий (бицепсов бедра) и ягодичных мышц. Выполняется в специальном тренажёре, где вы лежите на животе и сгибаете ноги в коленях, поднимая весовой блок. Это упражнение способствует увеличению силы и массы задней части бедра, улучшению стабильности коленного сустава и общего баланса нижних конечностей. Регулярное выполнение сгибаний ног помогает предотвратить травмы и улучшить спортивные показатели.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            'Ноги' => 80,
            'Спина' => 10,
            'Пресс' => 10,
        ];
        foreach ($muscles as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $leverLyingLegCurl->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Подколенные сухожилия', 'Ягодицы', 'Нижняя часть спины', 'Пресс'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $leverLyingLegCurl->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильное положение тела: Лягте на тренажёр так, чтобы колени находились на валиках, а бедра плотно прилегали к спинке скамьи. Это обеспечит правильную изоляцию мышц и предотвратит использование других групп мышц для подъёма веса.',
            'Контроль движения: Медленно сгибайте ноги, максимально сокращая подколенные сухожилия в нижней точке, затем плавно возвращайтесь в исходное положение. Избегайте резких движений, чтобы минимизировать риск травм.',
            'Дыхание: Вдыхайте при опускании ног и выдыхайте при их подъёме, поддерживая равномерное дыхание на протяжении всего подхода.',
            'Амплитуда движения: Полностью сгибайте ноги, не допуская частичного подъёма или опускания. Это обеспечит максимальную активацию целевых мышц.',
            'Выбор веса: Начинайте с минимального веса, чтобы освоить технику выполнения упражнения, и постепенно увеличивайте нагрузку по мере укрепления мышц. Не перегружайте тренажёр, чтобы избежать травм и сохранить правильную технику.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $leverLyingLegCurl->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Kettlebell Deadlift
        $kettlebellDeadlift = Exercise::create([
            'name' => 'Становая тяга с гирей',
            'video_url' => '/video/exercises/Kettlebell_Deadlift.mp4',
            'thumbnail_url' => '/images/thumbnail/Kettlebell_Deadlift.jpg',
            'min_weight_male' => 12,
            'max_weight_male' => 32,
            'min_weight_female' => 8,
            'max_weight_female' => 24,
            'description' => 'Становая тяга с гирей — это базовое упражнение для развития силы и массы задней цепи мышц, включая спину, ягодицы и ноги. Выполняется с использованием гири, что добавляет элемент стабилизации и акцентирует внимание на правильной технике выполнения. Это упражнение помогает улучшить осанку, укрепить мышцы кора и повысить общую физическую выносливость. Становая тяга с гирей подходит как для начинающих, так и для продвинутых атлетов, позволяя постепенно увеличивать нагрузку и улучшать свои показатели.',
        ]);
        
        // Связь с мышцами
        $muscles = [
            'Спина' => 40,
            'Ноги' => 35,
            'Руки' => 15,
            'Пресс' => 10,
        ];
        foreach ($muscles as $muscleName => $percentage) {
            $muscle = MusclePercentage::where('name', $muscleName)->first();
            if ($muscle) {
                $kettlebellDeadlift->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Нижняя часть спины', 'Ягодицы', 'Подколенные сухожилия', 'Предплечья'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $kettlebellDeadlift->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная постановка ног и спины: Расположите ноги на ширине плеч, носки слегка развернуты наружу. Держите спину прямой, избегайте округления позвоночника во время подъема и опускания гири.',
            'Использование полного диапазона движений: Опускайте гирю до уровня середины голени или чуть ниже, затем поднимайтесь, полностью выпрямляя тело. Это обеспечит максимальную активацию мышц.',
            'Контроль дыхания: Вдыхайте перед началом подъема, удерживайте дыхание на краткий момент, а затем выдыхайте при завершении подъема. Это поможет стабилизировать корпус и повысить эффективность упражнения.',
            'Минимизация использования рук: Сосредоточьтесь на работе ног и спины, позволяя рукам оставаться в расслабленном состоянии для лучшего захвата и стабилизации гири.',
            'Постепенное увеличение веса: Начинайте с легкого веса, чтобы освоить технику, и постепенно увеличивайте нагрузку, избегая резких скачков, чтобы снизить риск травм и обеспечить стабильный прогресс.',
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $kettlebellDeadlift->tips()->attach($tip->id);
        }
        
        // Упражнение 1: Lever Standing Leg Curl
        $leverStandingLegCurl = Exercise::create([
            'name' => 'Сгибание ног стоя в тренажёре',
            'video_url' => '/video/exercises/Lever_Standing_Leg_Curl.mp4',
            'thumbnail_url' => '/images/thumbnail/Lever_Standing_Leg_Curl.jpg',
            'min_weight_male' => 40,
            'max_weight_male' => 140,
            'min_weight_female' => 20,
            'max_weight_female' => 80,
            'description' => 'Сгибание ног стоя в тренажёре — это упражнение, направленное на развитие подколенных сухожилий, ягодиц и нижней части спины. Выполняется в специальном тренажёре, где стоя пользователь сгибает одну или обе ноги в коленном суставе против сопротивления. Это упражнение способствует увеличению силы и массы задней поверхности бедра, улучшению стабильности колена и общей функциональной силы нижних конечностей.',
        ]);
        
        // Связь с мышцами
        $muscleTensions = [
            ['name' => 'Ноги', 'percentages' => 80],
            ['name' => 'Спина', 'percentages' => 20],
        ];
        foreach ($muscleTensions as $muscleData) {
            $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
            if ($muscle) {
                $leverStandingLegCurl->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
            }
        }
        
        // Связь с фильтрами
        $filters = ['Подколенные сухожилия', 'Ягодицы', 'Нижняя часть спины'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $leverStandingLegCurl->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная постановка ног: Разместите ноги на платформе тренажёра на ширине плеч, убедитесь, что колени находятся под направлением платформы для предотвращения травм.',
            'Контроль движения: Сгибайте ноги медленно и контролируемо, избегая резких движений, чтобы максимально эффективно напрягать мышцы.',
            'Держите корпус стабильным: Сохраняйте прямую осанку и избегайте раскачивания тела, чтобы изолировать нагрузку на целевые мышцы.',
            'Дыхание: Вдыхайте при сгибании ног и выдыхайте при возвращении в исходное положение, поддерживая ритмичное дыхание.',
            'Не блокируйте колени в конце движения: Останавливайтесь на короткий момент в максимально сгибанном положении, избегая полного замыкания коленного сустава для предотвращения перенапряжения.'
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $leverStandingLegCurl->tips()->attach($tip->id);
        }
        
        // Упражнение 2: Lever Seated Leg Curl
        $leverSeatedLegCurl = Exercise::create([
            'name' => 'Сгибание ног в тренажере сидя',
            'video_url' => '/video/exercises/Lever_Seated_Leg_Curl.mp4',
            'thumbnail_url' => '/images/thumbnail/Lever_Seated_Leg_Curl.jpg',
            'min_weight_male' => 40,
            'max_weight_male' => 140,
            'min_weight_female' => 20,
            'max_weight_female' => 60,
            'description' => 'Сгибание ног в тренажере сидя — это упражнение, направленное на развитие подколенных сухожилий (бицепсов бедра). Выполняется сидя в специальном тренажере, при котором ноги сгибаются в коленных суставах, поднимая вес тренажера. Это упражнение способствует увеличению силы и массы подколенных сухожилий, улучшению гибкости и выносливости мышц задней поверхности бедра.',
        ]);
        
        // Связь с мышцами
        $muscle = MusclePercentage::where('name', 'Ноги')->first();
        if ($muscle) {
            $leverSeatedLegCurl->musclePercentages()->attach($muscle->id, ['percentages' => 100]);
        }
        
        // Связь с фильтрами
        $filter = MuscleFilter::where('name', 'Подколенные сухожилия')->first();
        if ($filter) {
            $leverSeatedLegCurl->muscleFilters()->attach($filter->id);
        }
        
        // Добавление советов
        $tips = [
            'Правильная посадка: Убедитесь, что сидение тренажера отрегулировано так, чтобы коленные суставы находились на одной линии с вращающимся механизмом тренажера.',
            'Контроль движения: Выполняйте сгибание и разгибание ног медленно и контролируемо, избегая резких движений, чтобы максимально изолировать подколенные сухожилия.',
            'Полный диапазон движений: Старайтесь выполнять упражнение через полный диапазон сгибания и разгибания, чтобы обеспечить максимальную активацию мышц.',
            'Дыхание: Вдыхайте при разгибании ног и выдыхайте при сгибании, поддерживая ритмичное дыхание на протяжении всего подхода.',
            'Избегайте перенапряжения: Не используйте чрезмерный вес, чтобы избежать травм и обеспечить правильную технику выполнения упражнения.'
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $leverSeatedLegCurl->tips()->attach($tip->id);
        }
        
        // Упражнение: Cable Standing Leg Curl
        $cableStandingLegCurl = Exercise::create([
            'name' => 'Сгибание ноги стоя на блоке',
            'video_url' => '/video/exercises/Cable_Standing_Leg_Curl.mp4',
            'thumbnail_url' => '/images/thumbnail/Cable_Standing_Leg_Curl.jpg',
            'min_weight_male' => 20,
            'max_weight_male' => 120,
            'min_weight_female' => 10,
            'max_weight_female' => 60,
            'description' => 'Сгибание ноги стоя на блоке — это упражнение, направленное на развитие подколенных сухожилий (задней поверхности бедра). Выполняется с использованием тренажера с кабелем, где одна нога фиксируется, а другая сгибается в коленном суставе против сопротивления. Это упражнение способствует увеличению силы и массы задней поверхности бедра, улучшая баланс мышц ног и предотвращая дисбаланс между передней и задней частями бедра. Регулярное выполнение сгибаний ног помогает улучшить спортивные показатели и общую функциональную силу нижних конечностей.',
        ]);
        
        // Связь с мышцами
        $legs = MusclePercentage::where('name', 'Ноги')->first();
        if ($legs) {
            $cableStandingLegCurl->musclePercentages()->attach($legs->id, ['percentages' => 100]);
        }
        
        // Связь с фильтрами
        $filters = ['Подколенные сухожилия', 'Ягодицы', 'Предплечья'];
        foreach ($filters as $filterName) {
            $filter = MuscleFilter::where('name', $filterName)->first();
            if ($filter) {
                $cableStandingLegCurl->muscleFilters()->attach($filter->id);
            }
        }
        
        // Добавление советов
        $tips = [
            'Правильная фиксация: Убедитесь, что бедро закреплено надежно на тренажере, чтобы изолировать подколенные сухожилия и избежать нежелательного движения бедра.',
            'Контроль движения: Выполняйте сгибание и разгибание ноги медленно и плавно, концентрируясь на сокращении подколенных сухожилий в верхней точке и полном растяжении в нижней.',
            'Положение корпуса: Держите корпус прямо и избегайте наклона вперед или назад, чтобы минимизировать нагрузку на поясницу и сфокусироваться на работе ног.',
            'Дыхание: Вдыхайте при разгибании ноги и выдыхайте при сгибании, поддерживая ритмичное дыхание на протяжении всего упражнения.',
            'Амплитуда движения: Используйте полный диапазон движений, но не допускайте чрезмерного сгибания колена, чтобы избежать травм и обеспечить максимальную эффективность упражнения.'
        ];
        foreach ($tips as $tipContent) {
            $tip = Tip::create(['content' => $tipContent]);
            $cableStandingLegCurl->tips()->attach($tip->id);
        }      
        

// Упражнение 2: Cable Donkey Kickback
$cableDonkeyKickback = Exercise::create([
    'name' => 'Отведение ноги назад на канатном тренажере',
    'video_url' => '/video/exercises/Cable_Donkey_Kickback.mp4',
    'thumbnail_url' => '/images/thumbnail/Cable_Donkey_Kickback.jpg',
    'min_weight_male' => 20,
    'max_weight_male' => 70,
    'min_weight_female' => 10,
    'max_weight_female' => 40,
    'description' => 'Отведение ноги назад на канатном тренажере — это упражнение, направленное на развитие ягодичных мышц и подколенных сухожилий. Выполняется с использованием кабельного тренажера, что позволяет изолировать и эффективно прорабатывать заднюю часть ног. Это упражнение помогает улучшить силу и выносливость ягодиц, а также способствует укреплению нижней части спины и общей стабилизации корпуса.',
]);

// Связь с мышцами напряжения
$muscleLegs = MusclePercentage::where('name', 'Ноги')->first();
$muscleBack = MusclePercentage::where('name', 'Спина')->first();
$muscleAbs = MusclePercentage::where('name', 'Пресс')->first();

if ($muscleLegs) {
    $cableDonkeyKickback->musclePercentages()->attach($muscleLegs->id, ['percentages' => 60]);
}

if ($muscleBack) {
    $cableDonkeyKickback->musclePercentages()->attach($muscleBack->id, ['percentages' => 30]);
}

if ($muscleAbs) {
    $cableDonkeyKickback->musclePercentages()->attach($muscleAbs->id, ['percentages' => 10]);
}

// Связь с фильтрами
$filters = ['Ягодицы', 'Подколенные сухожилия', 'Нижняя часть спины'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $cableDonkeyKickback->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Сохранение правильной осанки: Держите спину прямой и избегайте прогиба в пояснице на протяжении всего упражнения.',
    'Контролируемое движение: Выполняйте отведение ноги медленно и плавно, избегая резких рывков для минимизации риска травм.',
    'Максимальная активация мышц: На верхней точке движения сделайте короткую паузу, чтобы максимально напрячь ягодичные мышцы.',
    'Правильный угол отведения: Не поднимайте ногу слишком высоко, чтобы избежать избыточной нагрузки на поясницу и обеспечить эффективную работу целевых мышц.',
    'Использование полного диапазона движения: Полностью выпрямляйте ногу в нижней точке и максимально отводите в верхней, обеспечивая полный охват мышц.'
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $cableDonkeyKickback->tips()->attach($tip->id);
}

// Упражнение 1: Dumbbell Reverse Wrist Curl (Сгибание запястий с гантелями обратным хватом)
$dumbbellReverseWristCurl = Exercise::create([
    'name' => 'Сгибание запястий с гантелями обратным хватом',
    'video_url' => '/video/exercises/Dumbbell_Reverse_Wrist_Curl.mp4',
    'thumbnail_url' => '/images/thumbnail/Dumbbell_Reverse_Wrist_Curl.jpg',
    'min_weight_male' => 10,
    'max_weight_male' => 25,
    'min_weight_female' => 5,
    'max_weight_female' => 15,
    'description' => 'Сгибание запястий с гантелями обратным хватом — это упражнение, направленное на развитие и укрепление мышц предплечий, особенно разгибателей запястий. Выполняется с использованием гантелей, при этом кисти держатся в обратном положении по сравнению с традиционными сгибаниями запястий. Это упражнение помогает улучшить силу хвата и выносливость предплечий, что важно для различных видов спорта, а также для повседневных активностей, требующих устойчивости кистей и запястий.',
]);

// Связь с мышцами
$arms = MusclePercentage::where('name', 'Руки')->first();
if ($arms) {
    $dumbbellReverseWristCurl->musclePercentages()->attach($arms->id, ['percentages' => 100]);
}

// Связь с фильтрами
$filters = ['Предплечья'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $dumbbellReverseWristCurl->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Правильная позиция: Сидите на скамье, положите предплечья на бедра или специальную опору так, чтобы кисти свисали за края.',
    'Контроль движений: Поднимайте и опускайте гантели медленно и контролируемо, избегая рывков и быстрого движения.',
    'Прямая спина: Держите спину прямой и избегайте прогиба туловища во время выполнения упражнения.',
    'Полный диапазон: Выполняйте упражнение через полный диапазон движений для максимальной эффективности.',
    'Дыхание: Вдыхайте при опускании гантелей и выдыхайте при их подъеме.',
    'Регулярность: Включайте это упражнение в свою тренировочную программу 2-3 раза в неделю для достижения лучших результатов.',
    'Безопасность: Начинайте с легких весов, чтобы привыкнуть к технике выполнения, и постепенно увеличивайте нагрузку по мере укрепления мышц.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $dumbbellReverseWristCurl->tips()->attach($tip->id);
}

// Упражнение 2: Dumbbell Standing Wrist Curl (Подъем гантелей на запястья стоя)
$dumbbellStandingWristCurl = Exercise::create([
    'name' => 'Подъем гантелей на запястья стоя',
    'video_url' => '/video/exercises/Dumbbell_Standing_Wrist_Curl.mp4',
    'thumbnail_url' => '/images/thumbnail/Dumbbell_Standing_Wrist_Curl.jpg',
    'min_weight_male' => 5,
    'max_weight_male' => 25,
    'min_weight_female' => 2,
    'max_weight_female' => 15,
    'description' => 'Подъем гантелей на запястья стоя — это упражнение, направленное на развитие мышц предплечий. Выполняется стоя, с гантелями в руках, поднимая только запястья, при этом предплечья остаются неподвижными. Это упражнение улучшает силу и выносливость предплечий, что важно для улучшения хвата и общей функциональной силы рук. Регулярное выполнение подъемов на запястья способствует увеличению объема и силы предплечий, а также помогает в предотвращении травм при выполнении других упражнений и повседневных задач.',
]);

// Связь с мышцами
$arms = MusclePercentage::where('name', 'Руки')->first();
if ($arms) {
    $dumbbellStandingWristCurl->musclePercentages()->attach($arms->id, ['percentages' => 90]);
}

$abs = MusclePercentage::where('name', 'Пресс')->first();
if ($abs) {
    $dumbbellStandingWristCurl->musclePercentages()->attach($abs->id, ['percentages' => 10]);
}

// Связь с фильтрами
$filters = ['Предплечья'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $dumbbellStandingWristCurl->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Правильная позиция: Держите локти неподвижными и близко к телу, чтобы изолировать работу предплечий и избежать нагрузки на плечевые суставы.',
    'Контролируемое движение: Выполняйте подъемы и опускания медленно и плавно, избегая рывков и использования инерции.',
    'Полный диапазон движений: Полностью поднимайте гантели до максимальной высоты и опускайте до полного расслабления запястий для максимальной эффективности.',
    'Дыхание: Синхронизируйте дыхание с движениями — выдыхайте при подъеме гантелей и вдыхайте при их опускании.',
    'Постепенное увеличение веса: Начинайте с легких гантелей и постепенно увеличивайте вес по мере роста силы, чтобы избежать перегрузок и травм.',
    'Использование запястных ремней (по необходимости): Если у вас слабые запястья или вы используете тяжелые веса, можно использовать запястные ремни для дополнительной поддержки.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $dumbbellStandingWristCurl->tips()->attach($tip->id);
}

// Упражнение 3: Barbell Wrist Curl (Сгибание запястий со штангой)
$barbellWristCurl = Exercise::create([
    'name' => 'Сгибание запястий со штангой',
    'video_url' => '/video/exercises/Barbell_Wrist_Curl.mp4',
    'thumbnail_url' => '/images/thumbnail/Barbell_Wrist_Curl.jpg',
    'min_weight_male' => 20,
    'max_weight_male' => 60,
    'min_weight_female' => 10,
    'max_weight_female' => 40,
    'description' => 'Сгибание запястий со штангой — это упражнение, направленное на развитие сгибательных мышц предплечий. Оно выполняется путем сгибания запястий с удерживанием штанги, что способствует укреплению и увеличению массы предплечий. Это упражнение важно для улучшения хватательной силы и общей функциональности рук, а также для повышения устойчивости при выполнении других упражнений и повседневных задач.',
]);

// Связь с мышцами
$arms = MusclePercentage::where('name', 'Руки')->first();
if ($arms) {
    $barbellWristCurl->musclePercentages()->attach($arms->id, ['percentages' => 100]);
}

// Связь с фильтрами
$filters = ['Предплечья', 'Бицепс'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $barbellWristCurl->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Положение тела: Сядьте на скамью с прямой спиной, закрепите предплечья на бедрах так, чтобы запястья свисали за край коленей. Это обеспечит стабильность и изоляцию мышц предплечий.',
    'Движение: Медленно сгибайте запястья вверх, максимально сокращая мышцы предплечий, затем плавно опускайте штангу вниз, контролируя движение.',
    'Амплитуда: Выполняйте полный диапазон движений, чтобы обеспечить максимальное растяжение и сокращение мышц предплечий.',
    'Контроль веса: Начинайте с легкого веса, чтобы освоить технику, и постепенно увеличивайте нагрузку, избегая рывков и резких движений.',
    'Дыхание: Вдыхайте при опускании штанги и выдыхайте при сгибании запястий, поддерживая ритм дыхания и стабильность тела.',
    'Избегайте чрезмерного напряжения: Не поднимайте слишком тяжелые веса, чтобы избежать перенапряжения запястий и снижения эффективности упражнения.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $barbellWristCurl->tips()->attach($tip->id);
}

// Упражнение 4: Plate Pinch (Прижимание дисков)
$platePinch = Exercise::create([
    'name' => 'Прижимание дисков',
    'video_url' => '/video/exercises/Plate_Pinch.mp4',
    'thumbnail_url' => '/images/thumbnail/Plate_Pinch.jpg',
    'min_weight_male' => 10,
    'max_weight_male' => 50,
    'min_weight_female' => 5,
    'max_weight_female' => 25,
    'description' => 'Прижимание дисков — это упражнение, направленное на развитие силы хвата и укрепление предплечий. Выполняется путём удерживания двух весовых дисков вместе пальцами и большим пальцем рук на протяжении определённого времени. Это упражнение также задействует плечевые мышцы, мышцы спины и корпус для стабилизации тела. Прижимание дисков улучшает общую функциональную силу рук, что полезно для различных видов спорта и повседневных активностей, требующих сильного хвата.',
]);

// Связь с мышцами
$arms = MusclePercentage::where('name', 'Руки')->first();
if ($arms) {
    $platePinch->musclePercentages()->attach($arms->id, ['percentages' => 50]);
}

$shoulders = MusclePercentage::where('name', 'Плечи')->first();
if ($shoulders) {
    $platePinch->musclePercentages()->attach($shoulders->id, ['percentages' => 20]);
}

$back = MusclePercentage::where('name', 'Спина')->first();
if ($back) {
    $platePinch->musclePercentages()->attach($back->id, ['percentages' => 20]);
}

$abs = MusclePercentage::where('name', 'Пресс')->first();
if ($abs) {
    $platePinch->musclePercentages()->attach($abs->id, ['percentages' => 10]);
}

// Связь с фильтрами
$filters = ['Предплечья', 'Бицепс', 'Трицепс'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $platePinch->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Правильная стойка: Держите спину прямой и ноги на ширине плеч для устойчивости.',
    'Активный хват: Сжимайте диски максимально сильно, используя пальцы и большой палец для лучшего захвата.',
    'Контроль дыхания: Дышите равномерно, избегая задержки дыхания во время удерживания.',
    'Постепенное увеличение веса: Начинайте с небольших весов и постепенно увеличивайте нагрузку, чтобы избежать травм.',
    'Использование дополнительного хвата: При необходимости применяйте спортивный мел или перчатки для улучшения сцепления с дисками.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $platePinch->tips()->attach($tip->id);
}

// Упражнение 5: Barbell Reverse Wrist Curl (Обратные сгибания запястий со штангой)
$barbellReverseWristCurl = Exercise::create([
    'name' => 'Обратные сгибания запястий со штангой',
    'video_url' => '/video/exercises/Barbell_Reverse_Wrist_Curl.mp4',
    'thumbnail_url' => '/images/thumbnail/Barbell_Reverse_Wrist_Curl.jpg',
    'min_weight_male' => 20,
    'max_weight_male' => 60,
    'min_weight_female' => 10,
    'max_weight_female' => 30,
    'description' => 'Обратные сгибания запястий со штангой — это упражнение, направленное на развитие мышц предплечий, особенно разгибателей запястий. Выполняется с использованием штанги, что позволяет эффективно укреплять мышцы предплечий, улучшать их выносливость и силу. Регулярное выполнение этого упражнения способствует улучшению хватки и общей функциональной силы рук, что полезно как для спортивных достижений, так и для повседневной активности.',
]);

// Связь с мышцами
$arms = MusclePercentage::where('name', 'Руки')->first();
if ($arms) {
    $barbellReverseWristCurl->musclePercentages()->attach($arms->id, ['percentages' => 100]);
}

$filters = ['Предплечья', 'Бицепс', 'Трапеции'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $barbellReverseWristCurl->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Правильная позиция запястий: Держите запястья прямо, избегая их прогиба или чрезмерного сгибания, чтобы максимально нагрузить целевые мышцы и избежать травм.',
    'Контролируемые движения: Выполняйте сгибания и разгибания медленно и плавно, концентрируясь на работе мышц предплечий, а не на рывках с помощью инерции.',
    'Поддержка предплечий: Выполняйте упражнение сидя, поддерживая предплечья на скамье или коленях для стабильности и предотвращения раскачивания тела.',
    'Выбор подходящего веса: Начинайте с меньшего веса, постепенно увеличивая нагрузку по мере укрепления мышц предплечий, чтобы избежать перегрузки и травм.',
    'Дыхание: Не задерживайте дыхание; выдыхайте при подъёме штанги и вдыхайте при опускании, поддерживая ритмичное дыхание на протяжении всего подхода.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $barbellReverseWristCurl->tips()->attach($tip->id);
}

// Упражнение 2: Cable Wrist Curl (Кабельные сгибания запястий)
$cableWristCurl = Exercise::create([
    'name' => 'Кабельные сгибания запястий',
    'video_url' => '/video/exercises/Cable_Wrist_Curl.mp4',
    'thumbnail_url' => '/images/thumbnail/Cable_Wrist_Curl.jpg',
    'min_weight_male' => 10,
    'max_weight_male' => 40,
    'min_weight_female' => 5,
    'max_weight_female' => 20,
    'description' => 'Кабельные сгибания запястий — это изолирующее упражнение, направленное на развитие мышц предплечий, особенно сгибателей запястий. Выполняется с использованием тренажёра с тросом, что обеспечивает постоянное натяжение мышц на протяжении всего движения. Это упражнение помогает укрепить хват, улучшить выносливость и увеличить силу предплечий, что важно для выполнения различных упражнений и повседневных задач.',
]);

// Связь с мышцами
$muscle = MusclePercentage::where('name', 'Руки')->first();
if ($muscle) {
    $cableWristCurl->musclePercentages()->attach($muscle->id, ['percentages' => 100]);
}

// Связь с фильтрами
$filters = ['Предплечья', 'Бицепс'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $cableWristCurl->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Положение тела: Сидите на скамье с прямой спиной, закрепите предплечья на бедрах или на специальной подставке для устойчивости.',
    'Правильный захват: Держите рукоятку тренажёра или гриф параллельно полу, ладони направлены вверх.',
    'Контроль движения: Медленно сгибайте запястья, поднимая вес максимально высоко, затем плавно опускайте его обратно, избегая рывков.',
    'Дыхание: Вдыхайте при опускании веса и выдыхайте при его подъёме.',
    'Избегайте перегрузки: Начинайте с небольших весов, чтобы избежать перенапряжения сухожилий и связок, постепенно увеличивая нагрузку по мере укрепления мышц.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $cableWristCurl->tips()->attach($tip->id);
}

// Упражнение 3: Wrist Roller (Каталка для запястий)
$wristRoller = Exercise::create([
    'name' => 'Каталка для запястий',
    'video_url' => '/video/exercises/Wrist_Roller.mp4',
    'thumbnail_url' => '/images/thumbnail/Wrist_Roller.jpg',
    'min_weight_male' => 2,
    'max_weight_male' => 10,
    'min_weight_female' => 1,
    'max_weight_female' => 5,
    'description' => 'Каталка для запястий — это упражнение, направленное на развитие силы и выносливости мышц предплечий и кистей. С помощью специального устройства, состоящего из рукояти, верёвки и грузов, выполняется вращательное движение, которое способствует укреплению мышц предплечий, улучшению хватки и стабилизации кистей и плечевого пояса.',
]);

// Связь с мышцами
$muscles = [
    ['name' => 'Руки', 'percentages' => 90],
    ['name' => 'Плечи', 'percentages' => 10],
];
foreach ($muscles as $m) {
    $muscle = MusclePercentage::where('name', $m['name'])->first();
    if ($muscle) {
        $wristRoller->musclePercentages()->attach($muscle->id, ['percentages' => $m['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Предплечья', 'Бицепс', 'Трицепс', 'Плечи'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $wristRoller->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Правильная осанка: Держите спину прямо и избегайте раскачивания корпуса во время выполнения упражнения.',
    'Постепенная нагрузка: Начинайте с меньшего веса и постепенно увеличивайте нагрузку, чтобы предотвратить перенапряжение мышц.',
    'Контроль движения: Выполняйте движение медленно и контролируемо, концентрируясь на работе предплечий.',
    'Равномерное наматывание: Убедитесь, что верёвка равномерно намотана на рукоять, чтобы избежать перекоса и дисбаланса.',
    'Восстановление: Делайте перерывы между подходами для восстановления мышц.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $wristRoller->tips()->attach($tip->id);
}

// Упражнение 4: Cable Reverse Wrist Curl (Обратное сгибание запястий на блоке)
$cableReverseWristCurl = Exercise::create([
    'name' => 'Обратное сгибание запястий на блоке',
    'video_url' => '/video/exercises/Cable_Reverse_Wrist_Curl.mp4',
    'thumbnail_url' => '/images/thumbnail/Cable_Reverse_Wrist_Curl.jpg',
    'min_weight_male' => 5,
    'max_weight_male' => 20,
    'min_weight_female' => 2,
    'max_weight_female' => 10,
    'description' => 'Обратное сгибание запястий на блоке — это упражнение, направленное на развитие разгибателей предплечий. Оно помогает улучшить силу хвата и развить мышцы предплечий. Упражнение выполняется с использованием троса на блоке, что обеспечивает постоянное натяжение мышц в течение всего движения.',
]);

// Связь с мышцами
$muscles = [
    ['name' => 'Руки', 'percentages' => 80],
    ['name' => 'Плечи', 'percentages' => 15],
    ['name' => 'Спина', 'percentages' => 5],
];
foreach ($muscles as $m) {
    $muscle = MusclePercentage::where('name', $m['name'])->first();
    if ($muscle) {
        $cableReverseWristCurl->musclePercentages()->attach($muscle->id, ['percentages' => $m['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Предплечья', 'Бицепс', 'Трицепс'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $cableReverseWristCurl->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Держите движение под контролем, избегайте рывков.',
    'Не используйте чрезмерный вес, чтобы избежать перенапряжения запястий.',
    'Сохраняйте нейтральное положение спины и плеч.',
    'Избегайте раскачивания тела для обеспечения максимальной эффективности упражнения.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $cableReverseWristCurl->tips()->attach($tip->id);
}

// Упражнение 5: EZ Bar Seated Wrist Curl (Сгибание запястий сидя с EZ-штангой)
$ezBarSeatedWristCurl = Exercise::create([
    'name' => 'Сгибание запястий сидя с EZ-штангой',
    'video_url' => '/video/exercises/EZ_Bar_Seated_Wrist_Curl.mp4',
    'thumbnail_url' => '/images/thumbnail/EZ_Bar_Seated_Wrist_Curl.jpg',
    'min_weight_male' => 10,
    'max_weight_male' => 50,
    'min_weight_female' => 5,
    'max_weight_female' => 30,
    'description' => 'Сгибание запястий сидя с EZ-штангой — это упражнение, направленное на развитие мышц предплечий. Оно помогает увеличить силу и выносливость кистей и предплечий, что полезно как для спортивных целей, так и для повседневной активности. Упражнение выполняется в сидячем положении с опорой предплечий на скамье, что позволяет изолировать работу запястий и минимизировать участие других мышц.',
]);

// Связь с мышцами
$muscles = [
    ['name' => 'Руки', 'percentages' => 80],
    ['name' => 'Пресс', 'percentages' => 20],
];
foreach ($muscles as $m) {
    $muscle = MusclePercentage::where('name', $m['name'])->first();
    if ($muscle) {
        $ezBarSeatedWristCurl->musclePercentages()->attach($muscle->id, ['percentages' => $m['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Предплечья', 'Бицепс', 'Трицепс', 'Плечи'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $ezBarSeatedWristCurl->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Правильная постановка рук: Держите EZ-штангу таким образом, чтобы запястья находились в нейтральном положении, избегая чрезмерного сгибания или разгибания.',
    'Контроль движения: Выполняйте сгибание и разгибание запястий медленно и контролируемо, избегая рывков для максимальной эффективности нагрузки.',
    'Полный диапазон движений: Полностью сгибайте и разгибайте запястья, не сокращая амплитуду движения, чтобы обеспечить полный рабочий цикл мышцы.',
    'Фиксация предплечий: Убедитесь, что предплечья полностью опираются на скамью, чтобы избежать использования других мышц для стабилизации.',
    'Постепенное увеличение веса: Начинайте с легкого веса, постепенно увеличивая нагрузку по мере укрепления мышц, чтобы избежать травм.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $ezBarSeatedWristCurl->tips()->attach($tip->id);
}

// Упражнение 6: EZ Bar Seated Wrist Reverse Curl (Обратное сгибание запястья на скамье с EZ-баром)
$ezBarSeatedWristReverseCurl = Exercise::create([
    'name' => 'Обратное сгибание запястья на скамье с EZ-баром',
    'video_url' => '/video/exercises/EZ_Bar_Seated_Wrist_Reverse_Curl.mp4',
    'thumbnail_url' => '/images/thumbnail/EZ_Bar_Seated_Wrist_Reverse_Curl.jpg',
    'min_weight_male' => 10,
    'max_weight_male' => 40,
    'min_weight_female' => 5,
    'max_weight_female' => 20,
    'description' => 'Обратное сгибание запястья на скамье с EZ-баром направлено на развитие мышц предплечий, особенно мышц-разгибателей запястий и брахиорадиалиса. Упражнение выполняется сидя на скамье, что позволяет стабилизировать тело и изолировать работу предплечий. Использование EZ-бара снижает напряжение на запястья, делая упражнение более комфортным и безопасным по сравнению с прямым грифом. Регулярное выполнение этого упражнения способствует укреплению кистей, улучшению выносливости и повышению общей силы рук.',
]);

// Связь с мышцами
$muscles = [
    ['name' => 'Руки', 'percentages' => 80],
    ['name' => 'Плечи', 'percentages' => 10],
    ['name' => 'Спина', 'percentages' => 10],
];
foreach ($muscles as $m) {
    $muscle = MusclePercentage::where('name', $m['name'])->first();
    if ($muscle) {
        $ezBarSeatedWristReverseCurl->musclePercentages()->attach($muscle->id, ['percentages' => $m['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Предплечья', 'Бицепс', 'Трицепс'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $ezBarSeatedWristReverseCurl->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Правильная позиция: Сидите на скамье с устойчивой опорой для предплечий, ладони направлены вверх. Убедитесь, что ваши предплечья полностью поддерживаются, чтобы избежать участия других мышц.',
    'Контроль движения: Поднимайте и опускайте EZ-бар медленно и контролируемо, избегая рывков и резких движений. Это поможет максимизировать нагрузку на целевые мышцы и снизить риск травм.',
    'Полный диапазон движений: Полностью сгибайте и разгибайте запястья, достигая максимальной амплитуды каждого повторения для полного вовлечения мышц.',
    'Дыхание: Вдыхайте при опускании веса и выдыхайте при подъеме, поддерживая ритмичное дыхание на протяжении всего упражнения.',
    'Избегайте фиксации: Не задерживайте дыхание и не фиксируйте тело, чтобы предотвратить лишнее напряжение в спине и плечах.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $ezBarSeatedWristReverseCurl->tips()->attach($tip->id);
}

// Упражнение 1: Barbell Shrug (Шраги со штангой)
$barbellShrug = Exercise::create([
    'name' => 'Шраги со штангой',
    'video_url' => '/video/exercises/Barbell_Shrug.mp4',
    'thumbnail_url' => '/images/thumbnail/Barbell_Shrug.jpg',
    'min_weight_male' => 40,
    'max_weight_male' => 160,
    'min_weight_female' => 20,
    'max_weight_female' => 80,
    'description' => 'Шраги со штангой — это упражнение, направленное на развитие трапециевидных мышц спины. Выполняется путем подъема штанги за счет сокращения трапециевидных мышц, без сгибания локтей. Это упражнение помогает увеличить силу и объем трапеций, улучшить осанку и общую силу верхней части тела. Шраги со штангой также способствуют укреплению плечевого пояса и предплечий, что важно для выполнения других упражнений и повседневных физических задач.',
]);

// Связь с мышцами напряжения
$muscles = [
    ['name' => 'Руки', 'percentages' => 90],
    ['name' => 'Плечи', 'percentages' => 10],
];

foreach ($muscles as $muscleData) {
    $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
    if ($muscle) {
        $barbellShrug->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Трапеции', 'Плечи', 'Предплечья'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $barbellShrug->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Правильная стойка: Стоять прямо, ноги на ширине плеч, спина ровная. Избегайте наклона вперед или прогиба спины.',
    'Контроль движений: Поднимайте плечи максимально вверх, сокращая трапециевидные мышцы, и медленно опускайте их обратно, контролируя движение.',
    'Фиксированные локти: Держите локти слегка согнутыми и неподвижными во время всего упражнения, чтобы сосредоточить нагрузку на трапециях.',
    'Избегайте рывков: Не используйте инерцию для подъема штанги. Все движения должны быть плавными и контролируемыми.',
    'Дыхание: Вдыхайте при опускании штанги и выдыхайте при подъеме, поддерживая ритм дыхания для стабильности и эффективности упражнения.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $barbellShrug->tips()->attach($tip->id);
}

// Упражнение 2: Dumbbell Shrug (Шраги с гантелями)
$dumbbellShrug = Exercise::create([
    'name' => 'Шраги с гантелями',
    'video_url' => '/video/exercises/Dumbbell_Shrug.mp4',
    'thumbnail_url' => '/images/thumbnail/Dumbbell_Shrug.jpg',
    'min_weight_male' => 20,
    'max_weight_male' => 50,
    'min_weight_female' => 10,
    'max_weight_female' => 30,
    'description' => 'Шраги с гантелями — это упражнение, направленное на развитие трапециевидных мышц, которые расположены в верхней части спины и шее. Выполняя шраги, вы укрепляете верхнюю часть спины, улучшаете осанку и повышаете силу плечевого пояса. Это упражнение также способствует увеличению мышечной массы и выносливости в области шеи и плеч.',
]);

// Связь с мышцами напряжения
$muscles = [
    ['name' => 'Плечи', 'percentages' => 60],
    ['name' => 'Спина', 'percentages' => 40],
];

foreach ($muscles as $muscleData) {
    $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
    if ($muscle) {
        $dumbbellShrug->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Трапеции', 'Плечи', 'Предплечья'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $dumbbellShrug->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Правильная техника: Стоя прямо, ноги на ширине плеч, держите гантели по бокам с прямыми руками.',
    'Избегайте рывков: Поднимайте плечи медленно и контролируемо, избегая резких движений и раскачиваний тела.',
    'Полный диапазон движения: Поднимайте плечи максимально вверх, задерживайтесь на мгновение в верхней точке сокращения, затем медленно опускайте их вниз.',
    'Дыхание: Вдыхайте при опускании гантелей и выдыхайте при подъёме плеч.',
    'Фокус на мышцах: Концентрируйтесь на работе трапециевидных мышц, избегайте использования других мышц для подъёма веса.',
    'Без перенапряжения шеи: Не поднимайте плечи слишком высоко, чтобы избежать излишнего напряжения в шее.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $dumbbellShrug->tips()->attach($tip->id);
}

// Упражнение 3: Cable Shrug (Шраги на блоке)
$cableShrug = Exercise::create([
    'name' => 'Шраги на блоке',
    'video_url' => '/video/exercises/Cable_Shrug.mp4',
    'thumbnail_url' => '/images/thumbnail/Cable_Shrug.jpg',
    'min_weight_male' => 20,
    'max_weight_male' => 80,
    'min_weight_female' => 10,
    'max_weight_female' => 40,
    'description' => 'Шраги на блоке — это упражнение, направленное главным образом на трапециевидные мышцы, выполняемое с использованием тренажера с тросом. Оно способствует развитию силы шеи и верхней части спины, улучшению осанки и повышению стабильности плечевых суставов. Регулярное выполнение шрагов на блоке помогает создать мощную и хорошо развитую верхнюю часть тела.',
]);

// Связь с мышцами напряжения
$muscles = [
    ['name' => 'Спина', 'percentages' => 80],
    ['name' => 'Плечи', 'percentages' => 20],
];

foreach ($muscles as $muscleData) {
    $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
    if ($muscle) {
        $cableShrug->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Трапеции', 'Плечи', 'Предплечья'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $cableShrug->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Правильная техника: Держите спину прямой и избегайте прогиба во время выполнения упражнения.',
    'Контролируемое движение: Поднимайте плечи медленно и контролируемо, максимально сокращая трапециевидные мышцы в верхней точке.',
    'Избегайте раскачивания: Не используйте инерцию и не раскачивайтесь, чтобы нагрузка оставалась на целевых мышцах.',
    'Положение рук: Держите локти слегка согнутыми и старайтесь не сгибать руки во время шрагов.',
    'Дыхание: Вдыхайте при опускании плеч и выдыхайте при подъёме для поддержания ритма и стабильности.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $cableShrug->tips()->attach($tip->id);
}

// Упражнение 4: Barbell Upright Row (Тяга штанги к подбородку)
$barbellUprightRow = Exercise::create([
    'name' => 'Тяга штанги к подбородку',
    'video_url' => '/video/exercises/Barbell_Upright_Row.mp4',
    'thumbnail_url' => '/images/thumbnail/Barbell_Upright_Row.jpg',
    'min_weight_male' => 40,
    'max_weight_male' => 100,
    'min_weight_female' => 20,
    'max_weight_female' => 60,
    'description' => 'Тяга штанги к подбородку — это упражнение, направленное на развитие плечевых мышц, трапеций и бицепсов. Выполняется стоя, при этом штанга поднимается вертикально к подбородку, удерживая локти выше уровня рук. Это упражнение способствует увеличению силы и массы плечевого пояса, улучшению осанки и укреплению силы захвата.',
]);

// Связь с мышцами напряжения
$muscles = [
    ['name' => 'Плечи', 'percentages' => 50],
    ['name' => 'Руки', 'percentages' => 50],
];

foreach ($muscles as $muscleData) {
    $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
    if ($muscle) {
        $barbellUprightRow->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Плечи', 'Трапеции', 'Бицепс', 'Предплечья'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $barbellUprightRow->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Правильная осанка: Держите спину прямо и избегайте прогиба корпуса во время выполнения упражнения.',
    'Угол локтей: Ведите локти вверх под углом примерно 30 градусов от тела, чтобы максимально задействовать дельтовидные мышцы.',
    'Контроль движения: Выполняйте движение плавно и контролируемо, избегая резких рывков и раскачивания тела.',
    'Дыхание: Выдыхайте при подъёме штанги и вдыхайте при её опускании.',
    'Выбор веса: Начинайте с меньшего веса, постепенно увеличивая нагрузку по мере укрепления мышц, чтобы избежать травм.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $barbellUprightRow->tips()->attach($tip->id);
}

// Упражнение 5: Dumbbell Upright Row (Тяга гантелей к подбородку)
$dumbbellUprightRow = Exercise::create([
    'name' => 'Тяга гантелей к подбородку',
    'video_url' => '/video/exercises/Dumbbell_Upright_Row.mp4',
    'thumbnail_url' => '/images/thumbnail/Dumbbell_Upright_Row.jpg',
    'min_weight_male' => 20,
    'max_weight_male' => 50,
    'min_weight_female' => 10,
    'max_weight_female' => 30,
    'description' => 'Тяга гантелей к подбородку — это упражнение, направленное на развитие плечевых мышц и трапециевидных мышц спины. Выполняется с помощью гантелей, которые поднимаются вертикально до уровня подбородка, сохраняя локти слегка согнутыми. Это упражнение способствует укреплению верхней части тела, улучшению осанки и увеличению общей мышечной массы плечевого пояса.',
]);

// Связь с мышцами напряжения
$muscles = [
    ['name' => 'Плечи', 'percentages' => 50],
    ['name' => 'Руки', 'percentages' => 50],
];

foreach ($muscles as $muscleData) {
    $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
    if ($muscle) {
        $dumbbellUprightRow->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Плечи', 'Трапеции', 'Бицепс'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $dumbbellUprightRow->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Правильная постановка тела: Держите спину прямой, ноги на ширине плеч, слегка согнуты в коленях для устойчивости.',
    'Контроль движения: Поднимайте гантели медленно и контролируемо, избегая резких рывков, чтобы минимизировать риск травм плечевых суставов.',
    'Положение локтей: Локти должны быть слегка согнуты и направлены вверх во время подъема гантелей, что помогает эффективно задействовать целевые мышцы.',
    'Дыхание: Выдыхайте при подъеме гантелей и вдыхайте при опускании, поддерживая равномерное дыхание на протяжении всего упражнения.',
    'Выбор веса: Начинайте с минимального веса, чтобы освоить технику выполнения, и постепенно увеличивайте нагрузку по мере укрепления мышц.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $dumbbellUprightRow->tips()->attach($tip->id);
}

// Упражнение 6: Kettlebell Shrug (Шраги с гирей)
$kettlebellShrug = Exercise::create([
    'name' => 'Шраги с гирей',
    'video_url' => '/video/exercises/Kettlebell_Shrug.mp4',
    'thumbnail_url' => '/images/thumbnail/Kettlebell_Shrug.jpg',
    'min_weight_male' => 16,
    'max_weight_male' => 32,
    'min_weight_female' => 8,
    'max_weight_female' => 16,
    'description' => 'Шраги с гирей — это упражнение, направленное на развитие трапециевидных мышц, а также плеч и предплечий. Выполняется стоя с гирей в одной или обеих руках, что способствует укреплению верхней части спины и шеи. Регулярное выполнение шрагов с гирей улучшает осанку, увеличивает силу верхней части тела и способствует общей физической выносливости.',
]);

// Связь с мышцами напряжения
$muscles = [
    ['name' => 'Спина', 'percentages' => 60],
    ['name' => 'Плечи', 'percentages' => 30],
    ['name' => 'Руки', 'percentages' => 10],
];

foreach ($muscles as $muscleData) {
    $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
    if ($muscle) {
        $kettlebellShrug->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Трапеции', 'Плечи', 'Предплечья'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $kettlebellShrug->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Правильная стойка: Стойте прямо, ноги на ширине плеч, держа гирю в одной или обеих руках. Держите корпус устойчивым и избегайте раскачивания.',
    'Техника подъема: Поднимайте плечи вверх к ушам максимально высоко, задержитесь на вершине движения на 1-2 секунды, затем медленно опустите их обратно в исходное положение.',
    'Контроль движения: Держите руки прямыми и избегайте сгибания локтей. Не используйте инерцию или рывки для подъема гири — движение должно быть плавным и контролируемым.',
    'Дыхание: Вдыхайте при опускании гирь и выдыхайте при подъеме плеч.',
    'Избегайте лишнего напряжения: Не наклоняйтесь вперед или назад и не допускайте прогиба в спине. Сосредоточьтесь на работе трапециевидных мышц.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $kettlebellShrug->tips()->attach($tip->id);
}

// Упражнение 7: Lever Shrug (Шраги на тренажёре)
$leverShrug = Exercise::create([
    'name' => 'Шраги на тренажёре',
    'video_url' => '/video/exercises/Lever_Shrug.mp4',
    'thumbnail_url' => '/images/thumbnail/Lever_Shrug.jpg',
    'min_weight_male' => 40,
    'max_weight_male' => 160,
    'min_weight_female' => 20,
    'max_weight_female' => 80,
    'description' => 'Шраги на тренажёре — это упражнение, направленное на развитие трапециевидных мышц верхней части спины и плеч. Выполняется на специальном тренажёре с использованием рычага, что позволяет контролировать движение и равномерно распределять нагрузку. Шраги способствуют улучшению осанки, укреплению плечевого пояса и повышению общей силы верхней части тела.',
]);

// Связь с мышцами напряжения
$muscles = [
    ['name' => 'Спина', 'percentages' => 60],
    ['name' => 'Плечи', 'percentages' => 30],
    ['name' => 'Руки', 'percentages' => 10],
];

foreach ($muscles as $muscleData) {
    $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
    if ($muscle) {
        $leverShrug->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Верхняя часть спины', 'Трапеции', 'Плечи'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $leverShrug->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Правильная стойка: Встаньте прямо, ноги на ширине плеч, ступни устойчиво стоят на платформе тренажёра.',
    'Контроль движения: Медленно поднимайте плечи вверх, максимально сокращая трапециевидные мышцы, затем плавно опускайте их вниз без рывков.',
    'Дыхание: Вдыхайте при опускании плеч и выдыхайте при подъёме.',
    'Позиция рук: Держите руки слегка согнутыми в локтях, избегайте полного выпрямления, чтобы сохранить напряжение в трапециях.',
    'Фиксация корпуса: Не допускайте прогиба в спине; корпус должен оставаться стабильным на протяжении всего упражнения.',
    'Темп выполнения: Выполняйте упражнение в умеренном темпе, избегая слишком быстрого движения, чтобы сохранить контроль и эффективность нагрузки.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $leverShrug->tips()->attach($tip->id);
}

// Упражнение 8: Trap Bar Standing Shrug (Шраги с трап-баром)
$trapBarStandingShrug = Exercise::create([
    'name' => 'Шраги с трап-баром',
    'video_url' => '/video/exercises/Trap_Bar_Standing_Shrug.mp4',
    'thumbnail_url' => '/images/thumbnail/Trap_Bar_Standing_Shrug.jpg',
    'min_weight_male' => 40,
    'max_weight_male' => 120,
    'min_weight_female' => 20,
    'max_weight_female' => 80,
    'description' => 'Шраги с трап-баром — это упражнение, направленное на развитие трапециевидных мышц спины и плеч. Использование трап-бара позволяет равномерно распределить нагрузку и снизить напряжение в запястьях по сравнению с традиционной штангой. Упражнение способствует увеличению силы и массы верхней части спины, улучшению осанки и общей силы плечевого пояса. Оно также помогает в развитии стабилизационных мышц, что положительно влияет на выполнение других упражнений и повседневную активность.',
]);

// Связь с мышцами напряжения
$muscles = [
    ['name' => 'Спина', 'percentages' => 70],
    ['name' => 'Плечи', 'percentages' => 20],
    ['name' => 'Руки', 'percentages' => 10],
];

foreach ($muscles as $muscleData) {
    $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
    if ($muscle) {
        $trapBarStandingShrug->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Трапеции', 'Верхняя часть спины', 'Бицепс'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $trapBarStandingShrug->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Правильная постановка тела: Держите спину прямой и избегайте прогиба в пояснице. Ноги должны стоять на ширине плеч для стабильности.',
    'Диапазон движения: Поднимайте трап-бар только до уровня плеч. Не поднимайте его выше, чтобы избежать излишней нагрузки на шеи.',
    'Фокус на мышцах: Сосредоточьтесь на сокращении трапециевидных мышц при подъёме веса, а не на рывках или использовании инерции.',
    'Контроль веса: Выбирайте такой вес, который позволяет выполнять упражнение с правильной техникой. Плавные и контролируемые движения предотвращают травмы.',
    'Дыхание: Вдыхайте при опускании трап-бара и выдыхайте при подъёме, поддерживая стабильное дыхание на протяжении всего упражнения.',
    'Разминка: Перед выполнением шрагов с трап-баром обязательно разогрейте мышцы плеч и спины, чтобы подготовить их к нагрузке и снизить риск травм.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $trapBarStandingShrug->tips()->attach($tip->id);
}

// Упражнение 9: Barbell Overhead Shrug (Шраги со штангой над головой)
$barbellOverheadShrug = Exercise::create([
    'name' => 'Шраги со штангой над головой',
    'video_url' => '/video/exercises/Barbell_Overhead_Shrug.mp4',
    'thumbnail_url' => '/images/thumbnail/Barbell_Overhead_Shrug.jpg',
    'min_weight_male' => 40,
    'max_weight_male' => 100,
    'min_weight_female' => 20,
    'max_weight_female' => 60,
    'description' => 'Шраги со штангой над головой — это упражнение, направленное на развитие плечевых мышц и трапеций. Выполняется путем удержания штанги над головой с прямыми руками и последующего подъема плеч вверх. Это упражнение способствует укреплению верхней части спины, улучшению осанки и повышению общей силы плечевого пояса.',
]);

// Связь с мышцами напряжения
$muscles = [
    ['name' => 'Плечи', 'percentages' => 60],
    ['name' => 'Спина', 'percentages' => 40],
];

foreach ($muscles as $muscleData) {
    $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
    if ($muscle) {
        $barbellOverheadShrug->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Трапеции', 'Плечи', 'Широчайшие'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $barbellOverheadShrug->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Правильная стойка: Держите корпус прямо, ноги на ширине плеч, чтобы обеспечить стабильность и избежать прогиба в спине.',
    'Устойчивый хват: Используйте устойчивый хват штанги, чтобы предотвратить её скольжение и обеспечить контроль над движением.',
    'Контролируемые движения: Поднимайте плечи медленно и плавно, избегая резких рывков и использования инерции.',
    'Стабилизация: Сохраняйте штангу над головой на протяжении всего упражнения, стабилизируя тело и минимизируя движение других частей тела.',
    'Дыхание: Вдыхайте при опускании штанги и выдыхайте при подъеме плеч, поддерживая ритмичное дыхание.',
    'Разминка: Перед выполнением шрагов обязательно проведите разминку плеч и верхней части спины, чтобы подготовить мышцы и снизить риск травм.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $barbellOverheadShrug->tips()->attach($tip->id);
}

// Упражнение 1: Cable Triceps Pushdown (Разгибание рук на блоке)
$cableTricepsPushdown = Exercise::create([
    'name' => 'Разгибание рук на блоке',
    'video_url' => '/video/exercises/Cable_Triceps_Pushdown.mp4',
    'thumbnail_url' => '/images/thumbnail/Cable_Triceps_Pushdown.jpg',
    'min_weight_male' => 20,
    'max_weight_male' => 50,
    'min_weight_female' => 10,
    'max_weight_female' => 25,
    'description' => 'Разгибание рук на блоке — это изолирующее упражнение, направленное на развитие трицепсов. Выполняется с использованием каната или прямой рукоятки, закрепленной на верхнем блоке тренажера. Во время выполнения упражнения трицепсы активно работают, способствуя их росту и укреплению. Это упражнение также задействует предплечья и стабилизирующие мышцы плеч, обеспечивая баланс и контроль движений.',
]);

// Связь с мышцами
$muscles = [
    ['name' => 'Руки', 'percentages' => 95],
    ['name' => 'Плечи', 'percentages' => 5],
];

foreach ($muscles as $muscleData) {
    $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
    if ($muscle) {
        $cableTricepsPushdown->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Трицепс', 'Предплечья', 'Плечи'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $cableTricepsPushdown->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Позиция тела: Держите корпус прямо, слегка наклонившись вперёд от талии. Локти должны оставаться прижатыми к бокам и неподвижными на протяжении всего упражнения.',
    'Контроль движения: Медленно опускайте рукоятку, полностью выпрямляя руки. Избегайте рывков и резких движений, чтобы максимально задействовать трицепсы.',
    'Сокращение мышц: В конце каждого повторения сосредоточьтесь на полном сокращении трицепсов, удерживая напряжение на секунду перед возвращением в исходное положение.',
    'Дыхание: Выдыхайте при выжимании рукоятки вниз и вдыхайте при возвращении в исходное положение, поддерживая ритмичное дыхание.',
    'Выбор веса: Начинайте с минимального веса, чтобы освоить технику выполнения, и постепенно увеличивайте нагрузку по мере укрепления мышц.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $cableTricepsPushdown->tips()->attach($tip->id);
}

// Упражнение 2: Barbell Close Grip Bench Press (Жим штанги узким хватом лёжа)
$barbellCloseGripBenchPress = Exercise::create([
    'name' => 'Жим штанги узким хватом лёжа',
    'video_url' => '/video/exercises/Barbell_Close_Grip_Bench_Press.mp4',
    'thumbnail_url' => '/images/thumbnail/Barbell_Close_Grip_Bench_Press.jpg',
    'min_weight_male' => 60,
    'max_weight_male' => 160,
    'min_weight_female' => 30,
    'max_weight_female' => 80,
    'description' => 'Жим штанги узким хватом лёжа — это силовое упражнение, направленное преимущественно на развитие трицепсов, а также грудных мышц и плеч. Выполняется лёжа на скамье с узким хватом на штанге, что позволяет лучше изолировать трицепсы и снизить нагрузку на грудные мышцы по сравнению с классическим жимом штанги.',
]);

// Связь с мышцами
$muscles = [
    ['name' => 'Руки', 'percentages' => 50],
    ['name' => 'Грудь', 'percentages' => 30],
    ['name' => 'Плечи', 'percentages' => 20],
];

foreach ($muscles as $muscleData) {
    $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
    if ($muscle) {
        $barbellCloseGripBenchPress->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Трицепс', 'Грудь', 'Плечи'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $barbellCloseGripBenchPress->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Убедитесь, что хват на штанге достаточно узкий, примерно на ширине плеч или чуть уже.',
    'Держите локти близко к телу во время выполнения упражнения, чтобы максимизировать нагрузку на трицепсы.',
    'Контролируйте движение штанги, опуская её до уровня груди и полностью выжимая вверх, не блокируя локтевые суставы в верхней точке.',
    'Не прогибайте спину и сохраняйте устойчивое положение корпуса на протяжении всего упражнения.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $barbellCloseGripBenchPress->tips()->attach($tip->id);
}

// Упражнение 3: Cable Overhead Triceps Extension (Разгибание рук на блоке за головой)
$cableOverheadTricepsExtension = Exercise::create([
    'name' => 'Разгибание рук на блоке за головой',
    'video_url' => '/video/exercises/Cable_Overhead_Triceps_Extension.mp4',
    'thumbnail_url' => '/images/thumbnail/Cable_Overhead_Triceps_Extension.jpg',
    'min_weight_male' => 20,
    'max_weight_male' => 40,
    'min_weight_female' => 10,
    'max_weight_female' => 25,
    'description' => 'Разгибание рук на блоке за головой — изолирующее упражнение, направленное на развитие трицепсов. Выполняется с использованием кабельной машины, что обеспечивает постоянное напряжение мышцы на протяжении всего движения. Упражнение помогает улучшить силу и массу трицепсов, а также способствует улучшению общей эстетики рук. Дополнительно задействуются плечевые мышцы и мышцы кора для стабилизации тела во время выполнения.',
]);

// Связь с мышцами
$muscles = [
    ['name' => 'Руки', 'percentages' => 70],
    ['name' => 'Плечи', 'percentages' => 20],
    ['name' => 'Пресс', 'percentages' => 10],
];

foreach ($muscles as $muscleData) {
    $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
    if ($muscle) {
        $cableOverheadTricepsExtension->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Трицепс', 'Плечи', 'Предплечья'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $cableOverheadTricepsExtension->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Правильная позиция тела: Встаньте прямо, ноги на ширине плеч. Локти должны быть направлены вверх и оставаться неподвижными в течение всего упражнения.',
    'Контроль движения: Медленно опускайте рукоять за голову, максимально растягивая трицепсы, затем плавно возвращайте её в исходное положение, полностью выпрямляя руки.',
    'Избегайте раскачивания: Сохраняйте корпус стабильным, избегайте раскачивания тела для минимизации нагрузки на спину и обеспечение максимальной эффективности упражнения.',
    'Дыхание: Вдыхайте при опускании рукояти и выдыхайте при разгибании рук.',
    'Выбор веса: Начинайте с легкого веса, чтобы освоить технику выполнения, постепенно увеличивая нагрузку по мере укрепления мышц.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $cableOverheadTricepsExtension->tips()->attach($tip->id);
}

// Упражнение 4: Barbell Lying Triceps Extension Skull Crusher (Французский жим со штангой лёжа)
$barbellLyingTricepsExtension = Exercise::create([
    'name' => 'Французский жим со штангой лёжа',
    'video_url' => '/video/exercises/Barbell_Lying_Triceps_Extension_Skull_Crusher.mp4',
    'thumbnail_url' => '/images/thumbnail/Barbell_Lying_Triceps_Extension_Skull_Crusher.jpg',
    'min_weight_male' => 30,
    'max_weight_male' => 80,
    'min_weight_female' => 15,
    'max_weight_female' => 40,
    'description' => 'Французский жим со штангой лёжа — изолирующее упражнение, направленное на развитие трицепсов. Выполняется лёжа на скамье с штангой, которую необходимо опускать к лбу (отсюда и название "Skull Crusher") и затем выжимать обратно, активно задействуя трицепсы для подъёма и опускания веса. Это упражнение эффективно для наращивания силы и массы трицепсов, а также улучшения общей функциональной силы рук.',
]);

// Связь с мышцами
$muscles = [
    ['name' => 'Руки', 'percentages' => 75],
    ['name' => 'Плечи', 'percentages' => 15],
    ['name' => 'Грудь', 'percentages' => 10],
];

foreach ($muscles as $muscleData) {
    $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
    if ($muscle) {
        $barbellLyingTricepsExtension->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Трицепс', 'Плечи', 'Грудь'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $barbellLyingTricepsExtension->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Положение локтей: Держите локти неподвижными и близко к голове, чтобы максимально задействовать трицепсы и избежать нагрузки на плечевые суставы.',
    'Контроль движения: Выполняйте упражнение медленно и контролируемо, избегая резких рывков штангой.',
    'Диапазон движений: Используйте полный диапазон движения, опуская штангу до уровня лба и полностью выжимая её вверх, но без блокировки локтей в верхней точке.',
    'Положение тела: Поддерживайте спину плоской на скамье и избегайте прогиба, чтобы минимизировать риск травм плеч и спины.',
    'Дыхание: Вдыхайте при опускании штанги и выдыхайте при её выжимании, чтобы поддерживать стабильность корпуса и улучшить технику выполнения.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $barbellLyingTricepsExtension->tips()->attach($tip->id);
}

// Упражнение 5: Dumbbell Standing Kickback (Разгибание руки с гантелей стоя)
$dumbbellStandingKickback = Exercise::create([
    'name' => 'Разгибание руки с гантелей стоя',
    'video_url' => '/video/exercises/Dumbbell_Standing_Kickback.mp4',
    'thumbnail_url' => '/images/thumbnail/Dumbbell_Standing_Kickback.jpg',
    'min_weight_male' => 5,
    'max_weight_male' => 25,
    'min_weight_female' => 3,
    'max_weight_female' => 15,
    'description' => 'Разгибание руки с гантелей стоя — это упражнение, направленное на развитие трицепсов. Выполняется стоя, при этом одна рука держит гантель, а локоть фиксируется близко к телу. Основное движение заключается в разгибании локтя назад, что изолирует работу трицепса. Дополнительно вовлекаются плечевые мышцы и мышцы спины для стабилизации корпуса. Это упражнение помогает увеличить силу и массу трицепсов, улучшить общую выносливость рук.',
]);

// Связь с мышцами
$muscles = [
    ['name' => 'Руки', 'percentages' => 70],
    ['name' => 'Плечи', 'percentages' => 20],
    ['name' => 'Спина', 'percentages' => 10],
];

foreach ($muscles as $muscleData) {
    $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
    if ($muscle) {
        $dumbbellStandingKickback->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Трицепс', 'Плечи', 'Предплечья'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $dumbbellStandingKickback->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Поддерживайте правильную осанку: Держите спину прямой и избегайте раскачивания корпуса во время выполнения упражнения.',
    'Контролируйте движение: Выполняйте разгибание и сгибание локтя медленно и плавно, концентрируясь на сокращении трицепса.',
    'Фиксируйте локоть: Держите локоть неподвижным и близко к телу на протяжении всего упражнения, чтобы максимально изолировать трицепс.',
    'Выбирайте подходящий вес: Начинайте с более легких гантелей, чтобы освоить технику, и постепенно увеличивайте вес по мере роста силы.',
    'Дышите правильно: Вдыхайте при опускании гантели и выдыхайте при разгибании руки.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $dumbbellStandingKickback->tips()->attach($tip->id);
}

// Упражнение 6: Cable Single Arm Triceps Pushdown (Тросовое разгибание трицепса одной рукой)
$cableSingleArmTricepsPushdown = Exercise::create([
    'name' => 'Тросовое разгибание трицепса одной рукой',
    'video_url' => '/video/exercises/Cable_Single_Arm_Triceps_Pushdown.mp4',
    'thumbnail_url' => '/images/thumbnail/Cable_Single_Arm_Triceps_Pushdown.jpg',
    'min_weight_male' => 20,
    'max_weight_male' => 60,
    'min_weight_female' => 10,
    'max_weight_female' => 40,
    'description' => 'Тросовое разгибание трицепса одной рукой — это изолирующее упражнение, направленное на развитие мышц трицепса с использованием кабельного тренажера. Выполняется стоя, одна рука закреплена за рукоятью, после чего происходит разгибание предплечья вниз, с акцентом на сокращение трицепса. Упражнение помогает увеличить силу и массу трицепсов, а также улучшить общую форму рук.',
]);

// Связь с мышцами
$muscles = [
    ['name' => 'Руки', 'percentages' => 90],
    ['name' => 'Плечи', 'percentages' => 5],
    ['name' => 'Спина', 'percentages' => 5],
];

foreach ($muscles as $muscleData) {
    $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
    if ($muscle) {
        $cableSingleArmTricepsPushdown->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Трицепс', 'Предплечья'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $cableSingleArmTricepsPushdown->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Положение локтя: Держите локоть прижатым к телу на протяжении всего упражнения для максимальной активации трицепса.',
    'Контроль движения: Выполняйте движение медленно и контролируемо, избегая резких рывков и использования инерции.',
    'Диапазон движений: Используйте полный диапазон движений — полностью разгибайте руку вниз и плавно возвращайте рукоять в исходное положение.',
    'Дыхание: Дышите равномерно: выдыхайте при разгибании руки и вдыхайте при возвращении в исходное положение.',
    'Постановка ног: Расположите ноги на ширине плеч для устойчивости и предотвращения раскачивания тела.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $cableSingleArmTricepsPushdown->tips()->attach($tip->id);
}

// Упражнение 7: Dumbbell Lying Triceps Extension (Трицепс разгибание с гантелями лёжа)
$dumbbellLyingTricepsExtension = Exercise::create([
    'name' => 'Трицепс разгибание с гантелями лёжа',
    'video_url' => '/video/exercises/Dumbbell_Lying_Triceps_Extension.mp4',
    'thumbnail_url' => '/images/thumbnail/Dumbbell_Lying_Triceps_Extension.jpg',
    'min_weight_male' => 10,
    'max_weight_male' => 40,
    'min_weight_female' => 5,
    'max_weight_female' => 20,
    'description' => 'Трицепс разгибание с гантелями лёжа — упражнение, направленное на развитие трицепсов. Выполняется лёжа на скамье с гантелями, которые сгибаются в локтях и затем выпрямляются, эффективно прорабатывая мышцы рук. Это упражнение помогает увеличить силу и массу трицепсов, улучшить общую форму рук и способствует сбалансированному развитию верхней части тела.',
]);

// Связь с мышцами
$muscles = [
    ['name' => 'Трицепс', 'percentages' => 85],
    ['name' => 'Плечи', 'percentages' => 10],
    ['name' => 'Руки', 'percentages' => 5],
];

foreach ($muscles as $muscleData) {
    $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
    if ($muscle) {
        $dumbbellLyingTricepsExtension->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Трицепс', 'Плечи'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $dumbbellLyingTricepsExtension->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Положение тела: Лягте на скамью, стопы устойчиво стоят на полу. Держите спину плотно прижатой к скамье.',
    'Локти: Держите локти неподвижными и прижатыми к телу на протяжении всего упражнения, чтобы максимально нагрузить трицепсы.',
    'Движение: Опускайте гантели медленно и контролируемо до уровня головы, затем выжимайте их вверх, полностью выпрямляя руки.',
    'Дыхание: Выдыхайте при выпрямлении рук и вдыхайте при опускании гантелей.',
    'Вес: Выбирайте такой вес, который позволяет выполнять упражнение с правильной техникой. Слишком большой вес может привести к неправильному выполнению и травмам.',
    'Разминка: Перед выполнением упражнения проведите хорошую разминку для рук и плеч, чтобы подготовить мышцы к нагрузке.',
    'Контроль: Избегайте рывков и резких движений. Выполняйте упражнение плавно и с максимальной концентрацией на трицепсах.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $dumbbellLyingTricepsExtension->tips()->attach($tip->id);
}

// Упражнение 8: Lever Triceps Extension (Разгибание трицепса на тренажёре)
$leverTricepsExtension = Exercise::create([
    'name' => 'Разгибание трицепса на тренажёре',
    'video_url' => '/video/exercises/Lever_Triceps_Extension.mp4',
    'thumbnail_url' => '/images/thumbnail/Lever_Triceps_Extension.jpg',
    'min_weight_male' => 20,
    'max_weight_male' => 60,
    'min_weight_female' => 10,
    'max_weight_female' => 40,
    'description' => 'Разгибание трицепса на тренажёре — изолирующее упражнение, направленное на развитие мышц задней поверхности плеча (трицепсов). Выполняется с использованием специализированного тренажёра с рычагом, что обеспечивает стабильность движения и позволяет сосредоточиться на работе трицепсов. Это упражнение помогает увеличить силу и массу трицепсов, улучшить общую эстетику рук и повысить функциональную силу верхней части тела.',
]);

// Связь с мышцами
$muscles = [
    ['name' => 'Руки', 'percentages' => 90],
    ['name' => 'Плечи', 'percentages' => 10],
];

foreach ($muscles as $muscleData) {
    $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
    if ($muscle) {
        $leverTricepsExtension->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Трицепс', 'Плечи', 'Предплечья'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $leverTricepsExtension->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Правильная постановка тела: Сидите прямо, ноги устойчиво стоят на полу. Спина должна быть полностью поддержана спинкой тренажёра для предотвращения раскачивания.',
    'Контроль движения: Медленно опускайте рукоятку, полностью сгибая локти, затем плавно выпрямляйте руки, концентрируясь на сокращении трицепсов.',
    'Избегайте перегрузок: Используйте вес, который позволяет выполнять упражнение с правильной техникой. Слишком большой вес может привести к чрезмерной нагрузке на локти и плечи.',
    'Дыхание: Выдыхайте при выпрямлении рук и вдыхайте при сгибании. Ритмичное дыхание помогает поддерживать стабильность и контроль над движением.',
    'Минимизируйте участие других мышц: Сосредоточьтесь на работе трицепсов, избегая движения плечами или телом для дополнительного импульса.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $leverTricepsExtension->tips()->attach($tip->id);
}

// Упражнение 9: Cable Kickback (Тросовое отведение трицепса)
$cableKickback = Exercise::create([
    'name' => 'Тросовое отведение трицепса',
    'video_url' => '/video/exercises/Cable_Kickback.mp4',
    'thumbnail_url' => '/images/thumbnail/Cable_Kickback.jpg',
    'min_weight_male' => 10,
    'max_weight_male' => 25,
    'min_weight_female' => 5,
    'max_weight_female' => 15,
    'description' => 'Тросовое отведение трицепса — это изолирующее упражнение, направленное на развитие трицепсов. Оно выполняется с использованием троса на блочном тренажёре, что позволяет контролировать движение и поддерживать постоянное напряжение в мышцах на протяжении всего подхода. Это упражнение способствует увеличению массы и силы трицепсов, а также улучшает общую форму рук.',
]);

// Связь с мышцами
$muscles = [
    ['name' => 'Руки', 'percentages' => 80],
    ['name' => 'Плечи', 'percentages' => 10],
    ['name' => 'Спина', 'percentages' => 5],
    ['name' => 'Пресс', 'percentages' => 5],
];

foreach ($muscles as $muscleData) {
    $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
    if ($muscle) {
        $cableKickback->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Трицепс', 'Плечи'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $cableKickback->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Правильная позиция тела: Держите корпус неподвижным, слегка наклонившись вперёд от талии. Ноги расположите на ширине плеч для устойчивости.',
    'Контроль движения: Выполняйте упражнение медленно и плавно, избегая рывков. Полностью разгибайте руки, сокращая трицепсы в конце движения.',
    'Дыхание: Вдыхайте при опускании троса и выдыхайте при его отведении, синхронизируя дыхание с движением.',
    'Избегайте перегрузки: Используйте вес, который позволяет выполнять упражнение с правильной техникой. Слишком большой вес может привести к нарушению формы и снизить эффективность упражнения.',
    'Минимизация участия других мышц: Сосредоточьтесь на работе трицепсов, избегая использования рывков или раскачиваний тела для подъёма веса.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $cableKickback->tips()->attach($tip->id);
}

// Упражнение 10: Weighted Tricep Dip (Трицепсовые отжимания с дополнительным весом)
$weightedTricepDip = Exercise::create([
    'name' => 'Трицепсовые отжимания с дополнительным весом',
    'video_url' => '/video/exercises/Weighted_Tricep_Dip.mp4',
    'thumbnail_url' => '/images/thumbnail/Weighted_Tricep_Dip.jpg',
    'min_weight_male' => 10,
    'max_weight_male' => 50,
    'min_weight_female' => 5,
    'max_weight_female' => 30,
    'description' => 'Трицепсовые отжимания с дополнительным весом — это упражнение, направленное на развитие трицепсов, плечевых и грудных мышц. Выполняется на брусьях с использованием дополнительного веса, что позволяет увеличить нагрузку и стимулировать рост мышечной массы. Это упражнение также способствует улучшению силы верхней части тела и общей физической формы.',
]);

// Связь с мышцами
$muscles = [
    ['name' => 'Руки', 'percentages' => 50],
    ['name' => 'Плечи', 'percentages' => 20],
    ['name' => 'Грудь', 'percentages' => 20],
    ['name' => 'Пресс', 'percentages' => 10],
];

foreach ($muscles as $muscleData) {
    $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
    if ($muscle) {
        $weightedTricepDip->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Трицепс', 'Плечи', 'Грудь', 'Пресс'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $weightedTricepDip->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Поддерживайте правильную осанку: Держите тело прямо, избегая раскачивания, чтобы максимизировать нагрузку на трицепсы и снизить риск травм.',
    'Контролируйте движение: Медленно опускайтесь вниз до угла 90 градусов в локтях, затем мощно выжимайтесь вверх, полностью выпрямляя руки.',
    'Используйте полный диапазон движений: Полное опускание и выжимание обеспечивают максимальную активацию мышц.',
    'Избегайте чрезмерного прогиба спины: Сохраняйте корпус стабильным, чтобы нагрузка фокусировалась на целевых мышцах, а не на спине.',
    'Начинайте с малого веса: Если вы новичок, начните с минимального дополнительного веса и постепенно увеличивайте его по мере укрепления мышц.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $weightedTricepDip->tips()->attach($tip->id);
}

// Упражнение 1: Cable Wide Grip Lat Pulldown (Тяга верхнего блока широким хватом)
$cableWideGripLatPulldown = Exercise::create([
    'name' => 'Тяга верхнего блока широким хватом',
    'video_url' => '/video/exercises/Cable_Wide_Grip_Lat_Pulldown.mp4',
    'thumbnail_url' => '/images/thumbnail/Cable_Wide_Grip_Lat_Pulldown.jpg',
    'min_weight_male' => 40,
    'max_weight_male' => 100,
    'min_weight_female' => 20,
    'max_weight_female' => 60,
    'description' => 'Тяга верхнего блока широким хватом — это упражнение, направленное на развитие широчайших мышц спины, а также бицепсов и предплечий. Выполняется на тренажере с использованием широкого грифа, что позволяет максимально нагрузить верхнюю часть спины и улучшить ширину туловища. Правильная техника выполнения включает прямую спину, контроль движения и сведение лопаток в конце тяги, обеспечивая эффективную активацию целевых мышц.',
]);

// Связь с мышцами напряжения
$spina = MusclePercentage::where('name', 'Спина')->first();
$ruki = MusclePercentage::where('name', 'Руки')->first();
if ($spina && $ruki) {
    $cableWideGripLatPulldown->musclePercentages()->attach($spina->id, ['percentages' => 70]);
    $cableWideGripLatPulldown->musclePercentages()->attach($ruki->id, ['percentages' => 30]);
}

// Связь с фильтрами
$filters = ['Широчайшие', 'Бицепс', 'Предплечья'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $cableWideGripLatPulldown->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Правильная стойка: Держите спину прямой и устойчиво стойте, избегая раскачивания тела.',
    'Хват: Используйте широкий хват, расположив руки на ширине, превышающей ширину плеч.',
    'Движение: Тяните гриф вниз к верхней части груди, сводя лопатки вместе и концентрируясь на работе мышц спины.',
    'Контроль: Медленно и контролируемо опускайте гриф обратно, не позволяя ему резко подниматься.',
    'Дыхание: Вдыхайте при опускании грифа и выдыхайте при его подтягивании.',
    'Вес: Начинайте с умеренного веса, чтобы освоить технику, и постепенно увеличивайте нагрузку по мере укрепления мышц.'
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $cableWideGripLatPulldown->tips()->attach($tip->id);
}

// Упражнение 2: Cable Straight Arm Pulldown (Тяга нижнего блока прямыми руками)
$cableStraightArmPulldown = Exercise::create([
    'name' => 'Тяга нижнего блока прямыми руками',
    'video_url' => '/video/exercises/Cable_Straight_Arm_Pulldown.mp4',
    'thumbnail_url' => '/images/thumbnail/Cable_Straight_Arm_Pulldown.jpg',
    'min_weight_male' => 40,
    'max_weight_male' => 100,
    'min_weight_female' => 20,
    'max_weight_female' => 60,
    'description' => 'Тяга нижнего блока прямыми руками — это упражнение, направленное на развитие широчайших мышц спины. Выполняется с помощью каната или прямой рукояти на тренажере с нижним блоком. Основная цель упражнения — растягивание и сокращение широчайших мышц, что способствует улучшению ширины и толщины спины. Также активно задействуются трицепсы, плечи и мышцы кора для стабилизации тела во время выполнения движения.',
]);

// Связь с мышцами напряжения
$spina = MusclePercentage::where('name', 'Спина')->first();
$ruki = MusclePercentage::where('name', 'Руки')->first();
$plechi = MusclePercentage::where('name', 'Плечи')->first();
$press = MusclePercentage::where('name', 'Пресс')->first();
if ($spina && $ruki && $plechi && $press) {
    $cableStraightArmPulldown->musclePercentages()->attach($spina->id, ['percentages' => 60]);
    $cableStraightArmPulldown->musclePercentages()->attach($ruki->id, ['percentages' => 20]);
    $cableStraightArmPulldown->musclePercentages()->attach($plechi->id, ['percentages' => 10]);
    $cableStraightArmPulldown->musclePercentages()->attach($press->id, ['percentages' => 10]);
}

// Связь с фильтрами
$filters = ['Широчайшие', 'Трицепс', 'Плечи', 'Нижняя часть спины'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $cableStraightArmPulldown->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Правильная техника: Держите спину прямой и слегка наклонённой вперёд, избегайте прогиба в пояснице.',
    'Полный диапазон движений: Опускайте рукоять до уровня бедер, сохраняя руки прямыми, и медленно поднимайте их обратно, контролируя движение.',
    'Контроль скорости: Выполняйте упражнение плавно и контролируемо, избегая резких рывков.',
    'Дыхание: Вдыхайте при опускании рукояти и выдыхайте при подъёме.',
    'Минимизация использования инерции: Сосредоточьтесь на работе мышц спины, избегая чрезмерного использования рывков для подъёма веса.'
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $cableStraightArmPulldown->tips()->attach($tip->id);
}

// Упражнение 3: Lever Front Pulldown (Фронтальная тяга на блоке)
$leverFrontPulldown = Exercise::create([
    'name' => 'Фронтальная тяга на блоке',
    'video_url' => '/video/exercises/Lever_Front_Pulldown.mp4',
    'thumbnail_url' => '/images/thumbnail/Lever_Front_Pulldown.jpg',
    'min_weight_male' => 40,
    'max_weight_male' => 100,
    'min_weight_female' => 20,
    'max_weight_female' => 60,
    'description' => 'Фронтальная тяга на блоке — это упражнение для развития мышц спины, выполняемое на специальном тренажере с блоком и тросом. Основная нагрузка приходится на широчайшие мышцы спины, а также активно задействуются бицепсы и предплечья. Упражнение способствует увеличению силы и выносливости верхней части тела, улучшению осанки и формированию ширины спины. Правильная техника выполнения обеспечивает максимальную эффективность и снижает риск травм.',
]);

// Связь с мышцами напряжения
$spina = MusclePercentage::where('name', 'Спина')->first();
$ruki = MusclePercentage::where('name', 'Руки')->first();
$plechi = MusclePercentage::where('name', 'Плечи')->first();
if ($spina && $ruki && $plechi) {
    $leverFrontPulldown->musclePercentages()->attach($spina->id, ['percentages' => 75]);
    $leverFrontPulldown->musclePercentages()->attach($ruki->id, ['percentages' => 20]);
    $leverFrontPulldown->musclePercentages()->attach($plechi->id, ['percentages' => 5]);
}

// Связь с фильтрами
$filters = ['Широчайшие', 'Бицепс', 'Предплечья'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $leverFrontPulldown->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Поддерживайте прямую спину: Держите спину ровной и слегка наклонитесь назад, чтобы избежать чрезмерной нагрузки на поясницу.',
    'Контролируйте движение: Медленно тяните блок вниз к верхней части груди, концентрируясь на работе мышц спины.',
    'Избегайте рывков: Не используйте инерцию для выполнения упражнения, выполняйте движения плавно и контролируемо.',
    'Сфокусируйтесь на мышцах: Старайтесь ощущать напряжение в широчайших мышцах спины, а не в руках, чтобы обеспечить правильную активацию целевых мышц.'
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $leverFrontPulldown->tips()->attach($tip->id);
}

// Упражнение 4: Kettlebell Sumo High Pull (Сумо-подтягивание гири)
$kettlebellSumoHighPull = Exercise::create([
    'name' => 'Сумо-подтягивание гири',
    'video_url' => '/video/exercises/Kettlebell_Sumo_High_Pull.mp4',
    'thumbnail_url' => '/images/thumbnail/Kettlebell_Sumo_High_Pull.jpg',
    'min_weight_male' => 12,
    'max_weight_male' => 24,
    'min_weight_female' => 8,
    'max_weight_female' => 16,
    'description' => 'Сумо-подтягивание гири — это функциональное упражнение, сочетающее элементы силовой тренировки и кардионагрузки. Выполняется в широкой стойке сумо с гирей, которая поднимается от пола до уровня груди или подбородка. Упражнение эффективно развивает силу и выносливость ног, спины и рук, а также улучшает координацию движений и общую физическую форму. Благодаря широкому положению ног нагрузка равномерно распределяется, что позволяет активно работать над нижней частью тела и укреплять основные группы мышц.',
]);

// Связь с мышцами напряжения
$nogi = MusclePercentage::where('name', 'Ноги')->first();
$spina = MusclePercentage::where('name', 'Спина')->first();
$ruki = MusclePercentage::where('name', 'Руки')->first();
$plechi = MusclePercentage::where('name', 'Плечи')->first();
$press = MusclePercentage::where('name', 'Пресс')->first();
if ($nogi && $spina && $ruki && $plechi && $press) {
    $kettlebellSumoHighPull->musclePercentages()->attach($nogi->id, ['percentages' => 30]);
    $kettlebellSumoHighPull->musclePercentages()->attach($spina->id, ['percentages' => 25]);
    $kettlebellSumoHighPull->musclePercentages()->attach($ruki->id, ['percentages' => 20]);
    $kettlebellSumoHighPull->musclePercentages()->attach($plechi->id, ['percentages' => 15]);
    $kettlebellSumoHighPull->musclePercentages()->attach($press->id, ['percentages' => 10]);
}

// Связь с фильтрами
$filters = ['Верхняя часть спины', 'Ноги', 'Плечи', 'Трапеции', 'Бицепс'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $kettlebellSumoHighPull->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Поддерживайте правильную осанку: Держите спину прямой на протяжении всего упражнения, избегайте прогиба и наклона вперед.',
    'Используйте ноги для импульса: Начинайте движение с сильного выталкивания ног, используя их силу для подъема гири, а не только рук.',
    'Контролируйте вес гири: Избегайте рывков и резких движений, выполняйте упражнение плавно и контролируемо.',
    'Держите корпус напряжённым: Укреплённый корсет поможет стабилизировать тело и предотвратит раскачивание во время выполнения упражнения.',
    'Правильное дыхание: Выдыхайте при подъёме гири и вдыхайте при её опускании, поддерживая ритмичное дыхание.'
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $kettlebellSumoHighPull->tips()->attach($tip->id);
}

// Упражнение 5: Cable Reverse Grip Pulldown (Тяга верхнего блока обратным хватом)
$cableReverseGripPulldown = Exercise::create([
    'name' => 'Тяга верхнего блока обратным хватом',
    'video_url' => '/video/exercises/Cable_Reverse_Grip_Pulldown.mp4',
    'thumbnail_url' => '/images/thumbnail/Cable_Reverse_Grip_Pulldown.jpg',
    'min_weight_male' => 40,
    'max_weight_male' => 100,
    'min_weight_female' => 20,
    'max_weight_female' => 60,
    'description' => 'Тяга верхнего блока обратным хватом — упражнение, направленное на развитие широчайших мышц спины и бицепсов. Выполняется с помощью верхнего блока тренажёра, при котором хват осуществляется обратным (ладони обращены к себе). Такой хват позволяет лучше акцентировать нагрузку на бицепсах и задней части спины, улучшая форму и силу верхней части тела.',
]);

// Связь с мышцами напряжения
$spina = MusclePercentage::where('name', 'Спина')->first();
$ruki = MusclePercentage::where('name', 'Руки')->first();
$plechi = MusclePercentage::where('name', 'Плечи')->first();
if ($spina && $ruki && $plechi) {
    $cableReverseGripPulldown->musclePercentages()->attach($spina->id, ['percentages' => 60]);
    $cableReverseGripPulldown->musclePercentages()->attach($ruki->id, ['percentages' => 30]);
    $cableReverseGripPulldown->musclePercentages()->attach($plechi->id, ['percentages' => 10]);
}

// Связь с фильтрами
$filters = ['Широчайшие', 'Бицепс', 'Плечи', 'Предплечья'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $cableReverseGripPulldown->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Держите спину прямой и слегка наклонённой назад на протяжении всего упражнения.',
    'Тяните перекладину вниз к груди, сосредотачиваясь на сокращении широчайших мышц спины.',
    'Избегайте раскачивания тела, чтобы предотвратить использование инерции.',
    'Полностью выпрямляйте руки в конце движения для максимальной активации мышц.'
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $cableReverseGripPulldown->tips()->attach($tip->id);
}

// ---------------------------------------------------------------------------------------------

// Упражнение 6: Barbell Hip Thrust (Тяга бедра со штангой)
$barbellHipThrust = Exercise::create([
    'name' => 'Тяга бедра со штангой',
    'video_url' => '/video/exercises/Barbell_Hip_Thrust.mp4',
    'thumbnail_url' => '/images/thumbnail/Barbell_Hip_Thrust.jpg',
    'min_weight_male' => 60,
    'max_weight_male' => 150,
    'min_weight_female' => 40,
    'max_weight_female' => 100,
    'description' => 'Тяга бедра со штангой — это упражнение, направленное на развитие ягодичных мышц. Выполняется путем подъема бедер вверх, опираясь верхней частью спины на скамью, при этом штанга располагается на бедрах. Это упражнение не только увеличивает силу и объем ягодиц, но также укрепляет подколенные сухожилия и нижнюю часть спины, способствуя общей стабильности корпуса.',
]);

// Связь с мышцами напряжения
$nogi = MusclePercentage::where('name', 'Ноги')->first();
$spina = MusclePercentage::where('name', 'Спина')->first();
if ($nogi && $spina) {
    $barbellHipThrust->musclePercentages()->attach($nogi->id, ['percentages' => 90]);
    $barbellHipThrust->musclePercentages()->attach($spina->id, ['percentages' => 10]);
}

// Связь с фильтрами
$filters = ['Ягодицы', 'Подколенные сухожилия', 'Нижняя часть спины'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $barbellHipThrust->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Правильная фиксация: Убедитесь, что верхняя часть спины надежно закреплена на скамье, чтобы обеспечить стабильность во время выполнения упражнения.',
    'Активное сокращение ягодиц: При подъеме бедер концентрируйтесь на напряжении ягодичных мышц, избегая чрезмерного прогиба в пояснице.',
    'Контроль штанги: Держите штангу устойчиво, не позволяйте ей скользить вниз при опускании бедер.',
    'Плавное движение: Выполняйте подъем и опускание бедер плавно, контролируя каждую фазу упражнения для максимальной эффективности и безопасности.',
    'Дыхание: Вдыхайте при опускании бедер и выдыхайте при подъеме, поддерживая ритмичное дыхание на протяжении всего подхода.'
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $barbellHipThrust->tips()->attach($tip->id);
}

// Упражнение 7: Barbell Sumo Deadlift (Становая тяга сумо со штангой)
$barbellSumoDeadlift = Exercise::create([
    'name' => 'Становая тяга сумо со штангой',
    'video_url' => '/video/exercises/Barbell_Sumo_Deadlift.mp4',
    'thumbnail_url' => '/images/thumbnail/Barbell_Sumo_Deadlift.jpg',
    'min_weight_male' => 60,
    'max_weight_male' => 250,
    'min_weight_female' => 40,
    'max_weight_female' => 150,
    'description' => 'Становая тяга сумо со штангой — это силовое упражнение, направленное на развитие мышц ног, ягодиц и нижней части спины. Техника сумо позволяет более активно задействовать квадрицепсы и уменьшить нагрузку на поясницу по сравнению с классической станово́й тягой. Это упражнение способствует увеличению общей силы, улучшению стабилизации корпуса и развитию мышечной массы нижней части тела.',
]);

// Связь с мышцами напряжения
$nogi = MusclePercentage::where('name', 'Ноги')->first();
$spina = MusclePercentage::where('name', 'Спина')->first();
$press = MusclePercentage::where('name', 'Пресс')->first();
$plechi = MusclePercentage::where('name', 'Плечи')->first();
if ($nogi && $spina && $press && $plechi) {
    $barbellSumoDeadlift->musclePercentages()->attach($nogi->id, ['percentages' => 65]);
    $barbellSumoDeadlift->musclePercentages()->attach($spina->id, ['percentages' => 20]);
    $barbellSumoDeadlift->musclePercentages()->attach($press->id, ['percentages' => 10]);
    $barbellSumoDeadlift->musclePercentages()->attach($plechi->id, ['percentages' => 5]);
}

// Связь с фильтрами
$filters = ['Квадрицепс', 'Ягодицы', 'Нижняя часть спины', 'Пресс', 'Плечи'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $barbellSumoDeadlift->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Расставьте ноги шире, чем при классической станово́й тяге, носки слегка развернуты наружу.',
    'Держите спину прямой и напряжённой, избегайте прогиба в пояснице.',
    'Начинайте движение, выпрямляя ноги и приводя таз вперед одновременно.',
    'Дышите глубоко и равномерно, контролируя подъем штанги.',
    'Не допускайте рывков и резких движений, чтобы избежать травм.'
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $barbellSumoDeadlift->tips()->attach($tip->id);
}

// Упражнение 8: Lever Hip Thrust (Тяга бедер на блоке)
$leverHipThrust = Exercise::create([
    'name' => 'Тяга бедер на блоке',
    'video_url' => '/video/exercises/Lever_Hip_Thrust.mp4',
    'thumbnail_url' => '/images/thumbnail/Lever_Hip_Thrust.jpg',
    'min_weight_male' => 40,
    'max_weight_male' => 200,
    'min_weight_female' => 20,
    'max_weight_female' => 100,
    'description' => 'Тяга бедер на блоке — это упражнение, направленное на развитие ягодичных мышц, подколенных сухожилий и нижней части спины. Выполняется на специальном тренажёре с использованием рычага, что позволяет точно регулировать нагрузку и обеспечивать стабильную технику выполнения. Это упражнение способствует увеличению силы и массы ягодиц, улучшению формы нижней части спины и общей стабильности корпуса. Тяга бедер на блоке также помогает повысить спортивную производительность и уменьшить риск травм за счёт укрепления основных мышечных групп нижней части тела.',
]);

// Связь с мышцами напряжения
$nogi = MusclePercentage::where('name', 'Ноги')->first();
$spina = MusclePercentage::where('name', 'Спина')->first();
$press = MusclePercentage::where('name', 'Пресс')->first();
if ($nogi && $spina && $press) {
    $leverHipThrust->musclePercentages()->attach($nogi->id, ['percentages' => 60]);
    $leverHipThrust->musclePercentages()->attach($spina->id, ['percentages' => 25]);
    $leverHipThrust->musclePercentages()->attach($press->id, ['percentages' => 15]);
}

// Связь с фильтрами
$filters = ['Ягодицы', 'Подколенные сухожилия', 'Нижняя часть спины'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $leverHipThrust->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Правильная постановка ног: Установите ноги на платформу на ширине плеч, пятки полностью контактируют с ней для максимальной активации ягодичных мышц.',
    'Нейтральное положение спины: Сохраняйте спину прямой и нейтральной на протяжении всего упражнения, избегая чрезмерного прогиба или округления.',
    'Контролируемое движение: Выполняйте подъём бедер плавно и контролируемо, концентрируясь на сокращении ягодичных мышц в верхней фазе движения.',
    'Правильное дыхание: Выдыхайте при подъёме бедер и вдыхайте при их опускании, избегая задержки дыхания.',
    'Фокус на технике: Не используйте чрезмерный вес в ущерб правильной технике выполнения; качество движения важнее количества веса.'
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $leverHipThrust->tips()->attach($tip->id);
}

// Упражнение 9: Lever Glute Press (Жим ягодиц на тренажере с рычагом)
$leverGlutePress = Exercise::create([
    'name' => 'Жим ягодиц на тренажере с рычагом',
    'video_url' => '/video/exercises/Lever_Glute_Press.mp4',
    'thumbnail_url' => '/images/thumbnail/Lever_Glute_Press.jpg',
    'min_weight_male' => 80,
    'max_weight_male' => 300,
    'min_weight_female' => 40,
    'max_weight_female' => 160,
    'description' => 'Жим ягодиц на тренажере с рычагом — это упражнение, направленное на развитие ягодичных мышц и укрепление ног. Оно выполняется на специализированном тренажере, где вы, отталкиваясь ногами, выжимаете платформу, активно задействуя ягодицы, квадрицепсы и подколенные сухожилия. Это упражнение помогает увеличить силу и объем ягодиц, улучшить стабильность нижней части тела и повысить общую физическую выносливость.',
]);

// Связь с мышцами напряжения
$nogi = MusclePercentage::where('name', 'Ноги')->first();
$spina = MusclePercentage::where('name', 'Спина')->first();
$ruki = MusclePercentage::where('name', 'Руки')->first();
if ($nogi && $spina && $ruki) {
    $leverGlutePress->musclePercentages()->attach($nogi->id, ['percentages' => 70]);
    $leverGlutePress->musclePercentages()->attach($spina->id, ['percentages' => 25]);
    $leverGlutePress->musclePercentages()->attach($ruki->id, ['percentages' => 5]);
}

// Связь с фильтрами
$filters = ['Ягодицы', 'Квадрицепс', 'Подколенные сухожилия', 'Нижняя часть спины'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $leverGlutePress->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Положение ног: Разместите ноги на платформе на ширине плеч для равномерной нагрузки.',
    'Стабилизация спины: Держите спину плотно прижатой к спинке тренажера, избегая чрезмерного прогиба.',
    'Контроль движения: Выполняйте движение плавно и контролируемо, не блокируя коленные суставы в верхней точке.',
    'Дыхание: Вдыхайте при опускании платформы и выдыхайте при выжимании.',
    'Фокус на мышцах: Сосредоточьтесь на активном сокращении ягодичных мышц при каждом повторении.'
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $leverGlutePress->tips()->attach($tip->id);
}

// Упражнение 10: Weighted Glute Bridge (Ягодичный мост с отягощением)
$weightedGluteBridge = Exercise::create([
    'name' => 'Ягодичный мост с отягощением',
    'video_url' => '/video/exercises/Weighted_Glute_Bridge.mp4',
    'thumbnail_url' => '/images/thumbnail/Weighted_Glute_Bridge.jpg',
    'min_weight_male' => 40,
    'max_weight_male' => 100,
    'min_weight_female' => 20,
    'max_weight_female' => 50,
    'description' => 'Ягодичный мост с отягощением — это упражнение, направленное на развитие ягодичных мышц, подколенных сухожилий и нижней части спины. Выполняется лёжа на спине с согнутыми коленями и поднятием таза вверх с использованием дополнительного веса, например, штанги или гантели. Это упражнение способствует укреплению нижней части тела, улучшению осанки и повышению общей силы.',
]);

// Связь с мышцами напряжения
$nogi = MusclePercentage::where('name', 'Ноги')->first();
$spina = MusclePercentage::where('name', 'Спина')->first();
$press = MusclePercentage::where('name', 'Пресс')->first();
if ($nogi && $spina && $press) {
    $weightedGluteBridge->musclePercentages()->attach($nogi->id, ['percentages' => 70]);
    $weightedGluteBridge->musclePercentages()->attach($spina->id, ['percentages' => 20]);
    $weightedGluteBridge->musclePercentages()->attach($press->id, ['percentages' => 10]);
}

// Связь с фильтрами
$filters = ['Ягодицы', 'Подколенные сухожилия', 'Нижняя часть спины'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $weightedGluteBridge->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Положение ног: Держите ноги на ширине плеч, ступни плотно прижаты к полу.',
    'Техника подъема: Поднимайте таз до тех пор, пока тело не образует прямую линию от колен до плеч.',
    'Контроль спины: Избегайте чрезмерного прогиба в нижней части спины, концентрируйтесь на сокращении ягодичных мышц.',
    'Медленное опускание: Медленно опускайте таз обратно, контролируя движение.',
    'Напряжение корпуса: Держите пресс напряжённым для стабильности корпуса.'
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $weightedGluteBridge->tips()->attach($tip->id);
}

// Упражнение 11: Cable Hip Abduction (Отведение бедра на блоке)
$cableHipAbduction = Exercise::create([
    'name' => 'Отведение бедра на блоке',
    'video_url' => '/video/exercises/Cable_Hip_Abduction.mp4',
    'thumbnail_url' => '/images/thumbnail/Cable_Hip_Abduction.jpg',
    'min_weight_male' => 10,
    'max_weight_male' => 40,
    'min_weight_female' => 5,
    'max_weight_female' => 30,
    'description' => 'Отведение бедра на блоке — это упражнение, направленное на развитие мышц боковой поверхности бедра, особенно средней и малой ягодичных мышц. Оно также задействует плечи и мышцы пресса для стабилизации тела во время выполнения движения. Это упражнение помогает улучшить баланс, укрепить ноги и создать эстетичную форму ягодиц.',
]);

// Связь с мышцами напряжения
$nogi = MusclePercentage::where('name', 'Ноги')->first();
$plechi = MusclePercentage::where('name', 'Плечи')->first();
$press = MusclePercentage::where('name', 'Пресс')->first();
if ($nogi && $plechi && $press) {
    $cableHipAbduction->musclePercentages()->attach($nogi->id, ['percentages' => 70]);
    $cableHipAbduction->musclePercentages()->attach($plechi->id, ['percentages' => 20]);
    $cableHipAbduction->musclePercentages()->attach($press->id, ['percentages' => 10]);
}

// Связь с фильтрами
$filters = ['Ягодицы', 'Плечи', 'Пресс'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $cableHipAbduction->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Сидите прямо на тренажёре, закрепите лодыжку к нижнему блоке.',
    'Держите спину прямой и не допускайте прогиба в пояснице.',
    'Медленно отводите ногу в сторону, контролируя движение, не раскачивайтесь.',
    'В конце движения задержитесь на секунду, максимально сжимая ягодицы.',
    'Плавно верните ногу в исходное положение, не теряя контроля над весом.'
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $cableHipAbduction->tips()->attach($tip->id);
}

// Упражнение 2: Barbell Decline Bench Press
$barbellDeclineBenchPress = Exercise::create([
    'name' => 'Жим штанги с наклоном вниз',
    'video_url' => '/video/exercises/Barbell_Decline_Bench_Press.mp4',
    'thumbnail_url' => '/images/thumbnail/Barbell_Decline_Bench_Press.jpg',
    'min_weight_male' => 30,
    'max_weight_male' => 120,
    'min_weight_female' => 15,
    'max_weight_female' => 50,
    'description' => 'Жим штанги с наклоном вниз — это упражнение, которое акцентирует нагрузку на нижнюю часть грудных мышц. В отличие от традиционного жима лёжа, наклон вниз помогает уменьшить нагрузку на плечевые суставы и увеличить активность нижней части груди. Это отличное упражнение для улучшения пропорциональности груди и развития её нижнего отдела.',
]);

// Связь с мышцами
$muscles = [
    ['name' => 'Грудь', 'percentage' => 70],
    ['name' => 'Руки', 'percentage' => 20],
    ['name' => 'Плечи', 'percentage' => 10],
];

foreach ($muscles as $muscleData) {
    $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
    if ($muscle) {
        $barbellDeclineBenchPress->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentage']]);
    }
}

// Связь с фильтрами
$filters = ['Грудь', 'Трицепс', 'Плечи'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $barbellDeclineBenchPress->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Держите спину прижатой к скамье, а ноги плотно расположены на полу для стабильности.',
    'Опускайте штангу до уровня груди, не позволяйте ей «падать» на тело.',
    'Локти должны быть под углом 45 градусов к туловищу, чтобы не перегружать плечи.',
    'Используйте полный диапазон движения для максимальной активации грудных мышц.'
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $barbellDeclineBenchPress->tips()->attach($tip->id);
}

// Упражнение 2: Barbell Reverse Curl
$barbellReverseCurl = Exercise::create([
    'name' => 'Обратное сгибание рук со штангой',
    'video_url' => '/video/exercises/Barbell_Reverse_Curl.mp4',
    'thumbnail_url' => '/images/thumbnail/Barbell_Reverse_Curl.jpg',
    'min_weight_male' => 10,
    'max_weight_male' => 40,
    'min_weight_female' => 5,
    'max_weight_female' => 20,
    'description' => 'Обратное сгибание рук со штангой — это упражнение, направленное на укрепление предплечий и плечевой мышцы. Благодаря хвату сверху, основная нагрузка приходится на предплечья, с меньшим вовлечением бицепсов. Подходит для повышения силы хвата и гармоничного развития мышц рук.',
]);

// Связь с мышцами
$muscleTensions = [
    'Руки' => 90,
    'Плечи' => 10,
];
foreach ($muscleTensions as $muscleName => $percentage) {
    $muscle = MusclePercentage::where('name', $muscleName)->first();
    if ($muscle) {
        $barbellReverseCurl->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
    }
}

// Связь с фильтрами
$filters = ['Предплечья', 'Бицепс', 'Плечи'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $barbellReverseCurl->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Держите спину прямой, избегая раскачивания корпуса.',
    'Убедитесь, что локти остаются неподвижными и прижатыми к телу.',
    'Используйте контролируемое движение, особенно в негативной фазе.',
    'Начинайте с умеренного веса, чтобы предотвратить чрезмерное напряжение запястий.'
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $barbellReverseCurl->tips()->attach($tip->id);
}

// Упражнение 2: Cable Curl
$cableCurl = Exercise::create([
    'name' => 'Сгибание рук на верхнем блоке',
    'video_url' => '/video/exercises/Cable_Curl.mp4',
    'thumbnail_url' => '/images/thumbnail/Cable_Curl.jpg',
    'min_weight_male' => 10,
    'max_weight_male' => 40,
    'min_weight_female' => 5,
    'max_weight_female' => 20,
    'description' => 'Сгибание рук на верхнем блоке с использованием рукоятки или веревки — это изолированное упражнение для бицепсов. Оно позволяет поддерживать постоянное напряжение в мышцах на протяжении всего движения. Отлично подходит как для начинающих, так и для опытных атлетов.',
]);

// Связь с мышцами
$biceps = MusclePercentage::where('name', 'Руки')->first();
if ($biceps) {
    $cableCurl->musclePercentages()->attach($biceps->id, ['percentages' => 100]);
}

// Связь с фильтрами
$filters = ['Бицепс', 'Предплечья'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $cableCurl->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Держите локти неподвижными, прижимая их к туловищу.',
    'Контролируйте движение на всем протяжении, избегая рывков.',
    'Настройте блок так, чтобы натяжение сохранялось даже в нижней точке амплитуды.',
    'Дышите равномерно: выдох при подъеме, вдох при опускании рукоятки.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $cableCurl->tips()->attach($tip->id);
}

// Упражнение 2: Dumbbell Concentration Curl
$dumbbellConcentrationCurl = Exercise::create([
    'name' => 'Сгибание рук с гантелью на скамье',
    'video_url' => '/video/exercises/Dumbbell_Concentration_Curl.mp4',
    'thumbnail_url' => '/images/thumbnail/Dumbbell_Concentration_Curl.jpg',
    'min_weight_male' => 5,
    'max_weight_male' => 25,
    'min_weight_female' => 3,
    'max_weight_female' => 15,
    'description' => 'Сгибание рук с гантелью на скамье — изолированное упражнение, позволяющее сосредоточиться на проработке бицепсов, минимизируя участие других мышц. Выполняется сидя с упором локтя в бедро. Помогает улучшить форму и пиковую силу бицепса.',
]);

// Связь с мышцами
$arms = MusclePercentage::where('name', 'Руки')->first();
if ($arms) {
    $dumbbellConcentrationCurl->musclePercentages()->attach($arms->id, ['percentages' => 100]);
}

// Связь с фильтрами
$filters = ['Бицепс', 'Предплечья'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $dumbbellConcentrationCurl->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Убедитесь, что локоть плотно прижат к бедру на протяжении всего упражнения.',
    'Выполняйте движение медленно и подконтрольно, избегая рывков.',
    'На пике сокращения задерживайтесь на 1-2 секунды для максимального напряжения мышцы.',
    'Держите спину ровной, чтобы не снижать эффективность упражнения.'
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $dumbbellConcentrationCurl->tips()->attach($tip->id);
}

// Упражнение 2: Dumbbell Zottman Curl
$dumbbellZottmanCurl = Exercise::create([
    'name' => 'Сгибание рук с гантелями по методу Зоттмана',
    'video_url' => '/video/exercises/Dumbbell_Zottman_Curl.mp4',
    'thumbnail_url' => '/images/thumbnail/Dumbbell_Zottman_Curl.jpg',
    'min_weight_male' => 5,
    'max_weight_male' => 20,
    'min_weight_female' => 3,
    'max_weight_female' => 10,
    'description' => 'Сгибание рук с гантелями по методу Зоттмана — это уникальное упражнение, которое сочетает сгибание для бицепса в подъеме и акцент на предплечья в опускании. Оно улучшает силу и выносливость рук, развивает мышцы стабилизаторы и увеличивает объем предплечий.',
]);

// Связь с мышцами
$hands = MusclePercentage::where('name', 'Руки')->first();
if ($hands) {
    $dumbbellZottmanCurl->musclePercentages()->attach($hands->id, ['percentages' => 100]);
}

// Связь с фильтрами
$filters = ['Бицепс', 'Предплечья'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $dumbbellZottmanCurl->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Выполняйте сгибание с супинированным (ладони вверх) хватом, а опускание — с пронированным (ладони вниз).',
    'Держите локти неподвижными, прижимая их к туловищу.',
    'Контролируйте темп, особенно в негативной (опускание) фазе движения.',
    'Используйте умеренный вес для правильной техники и максимального контроля.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $dumbbellZottmanCurl->tips()->attach($tip->id);
}

// Упражнение 1: Dumbbell Incline Biceps Curl
$dumbbellInclineCurl = Exercise::create([
    'name' => 'Сгибание рук с гантелями на наклонной скамье',
    'video_url' => '/video/exercises/Dumbbell_Incline_Biceps_Curl.mp4',
    'thumbnail_url' => '/images/thumbnail/Dumbbell_Incline_Biceps_Curl.jpg',
    'min_weight_male' => 5,
    'max_weight_male' => 25,
    'min_weight_female' => 3,
    'max_weight_female' => 12,
    'description' => 'Сгибание рук с гантелями на наклонной скамье — изолированное упражнение, которое увеличивает растяжение бицепсов за счет положения тела. Оно позволяет эффективно прорабатывать нижнюю часть бицепса и увеличивать его объем.',
]);

// Связь с мышцами
$biceps = MusclePercentage::where('name', 'Руки')->first();
if ($biceps) {
    $dumbbellInclineCurl->musclePercentages()->attach($biceps->id, ['percentages' => 100]);
}

// Связь с фильтрами
$filters = ['Бицепс', 'Предплечья'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $dumbbellInclineCurl->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Убедитесь, что спина и плечи остаются плотно прижатыми к скамье.',
    'Избегайте рывков, контролируйте движение на подъеме и опускании.',
    'Держите локти неподвижными и избегайте их смещения вперед.',
    'Используйте полную амплитуду для максимального растяжения и сокращения бицепсов.'
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $dumbbellInclineCurl->tips()->attach($tip->id);
}

// Упражнение 2: EZ Bar Curl
$ezBarCurl = Exercise::create([
    'name' => 'Сгибание рук с EZ-грифом',
    'video_url' => '/video/exercises/EZ_Bar_Curl.mp4',
    'thumbnail_url' => '/images/thumbnail/EZ_Bar_Curl.jpg',
    'min_weight_male' => 15,
    'max_weight_male' => 50,
    'min_weight_female' => 7,
    'max_weight_female' => 25,
    'description' => 'Сгибание рук с EZ-грифом — базовое упражнение для проработки бицепсов. Изогнутая форма грифа снижает нагрузку на запястья и локтевые суставы, что делает его удобным для выполнения даже с большим весом. Подходит для спортсменов любого уровня подготовки.',
]);

// Связь с мышцами
$biceps = MusclePercentage::where('name', 'Руки')->first();
if ($biceps) {
    $ezBarCurl->musclePercentages()->attach($biceps->id, ['percentages' => 100]);
}

// Связь с фильтрами
$filters = ['Бицепс', 'Предплечья'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $ezBarCurl->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Держите локти неподвижными и прижатыми к туловищу.',
    'Избегайте раскачивания корпуса, сосредотачиваясь на работе бицепсов.',
    'Используйте контролируемый темп и избегайте рывков.',
    'В нижней точке не разгибайте руки полностью, чтобы сохранять напряжение в мышцах.'
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $ezBarCurl->tips()->attach($tip->id);
}

// Упражнение 2: Lever Biceps Curl
$leverBicepsCurl = Exercise::create([
    'name' => 'Сгибание рук на тренажере',
    'video_url' => '/video/exercises/Lever_Biceps_Curl.mp4',
    'thumbnail_url' => '/images/thumbnail/Lever_Biceps_Curl.jpg',
    'min_weight_male' => 10,
    'max_weight_male' => 40,
    'min_weight_female' => 5,
    'max_weight_female' => 20,
    'description' => 'Сгибание рук на тренажере — изолированное упражнение для бицепсов, которое обеспечивает стабильную амплитуду движения. Позволяет сосредоточиться на проработке мышц без вовлечения стабилизаторов. Отлично подходит для новичков и восстановления после травм.',
]);

// Связь с мышцами
$biceps = MusclePercentage::where('name', 'Руки')->first();
if ($biceps) {
    $leverBicepsCurl->musclePercentages()->attach($biceps->id, ['percentages' => 100]);
}

// Связь с фильтрами
$filters = ['Бицепс', 'Предплечья'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $leverBicepsCurl->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Регулируйте положение сиденья так, чтобы локти были плотно зафиксированы.',
    'Двигайте рычаги плавно, избегая резких рывков.',
    'Полностью контролируйте движение как в подъемной, так и в опускной фазах.',
    'Следите, чтобы напряжение в бицепсах сохранялось на протяжении всего упражнения.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $leverBicepsCurl->tips()->attach($tip->id);
}

// Упражнение 2: Dumbbell Standing One Arm Curl
$dumbbellCurl = Exercise::create([
    'name' => 'Сгибание одной руки с гантелью стоя',
    'video_url' => '/video/exercises/Dumbbell_Standing_One_Arm_Curl.mp4',
    'thumbnail_url' => '/images/thumbnail/Dumbbell_Standing_One_Arm_Curl.jpg',
    'min_weight_male' => 5,
    'max_weight_male' => 25,
    'min_weight_female' => 3,
    'max_weight_female' => 12,
    'description' => 'Сгибание одной руки с гантелью стоя — классическое изолированное упражнение для бицепсов, позволяющее сосредоточиться на работе одной руки за раз. Это помогает улучшить симметрию и устранить дисбаланс между руками.',
]);

// Связь с мышцами
$biceps = MusclePercentage::where('name', 'Руки')->first();
if ($biceps) {
    $dumbbellCurl->musclePercentages()->attach($biceps->id, ['percentages' => 100]);
}

// Связь с фильтрами
$filters = ['Бицепс', 'Предплечья'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $dumbbellCurl->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Держите локоть неподвижным, прижимая его к туловищу.',
    'Контролируйте движение на всем протяжении, избегая рывков.',
    'Используйте полную амплитуду для максимального сокращения и растяжения бицепса.',
    'Не наклоняйте корпус в сторону работающей руки, чтобы избежать читинга.'
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $dumbbellCurl->tips()->attach($tip->id);
}

// Упражнение 2: EZ Barbell Spider Curl
$ezBarbellSpiderCurl = Exercise::create([
    'name' => 'Сгибание рук с EZ-грифом на скамье "паука"',
    'video_url' => '/video/exercises/EZ_Barbell_Spider_Curl.mp4',
    'thumbnail_url' => '/images/thumbnail/EZ_Barbell_Spider_Curl.jpg',
    'min_weight_male' => 15,
    'max_weight_male' => 40,
    'min_weight_female' => 7,
    'max_weight_female' => 20,
    'description' => 'Сгибание рук с EZ-грифом на скамье "паука" — изолированное упражнение для бицепсов, выполняемое на специальной наклонной скамье. Это положение позволяет исключить читинг и сконцентрировать всю нагрузку на бицепсах, особенно на их пиковом сокращении.',
]);

// Связь с мышцами
$biceps = MusclePercentage::where('name', 'Руки')->first();
if ($biceps) {
    $ezBarbellSpiderCurl->musclePercentages()->attach($biceps->id, ['percentages' => 100]);
}

// Связь с фильтрами
$filters = ['Бицепс', 'Предплечья'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $ezBarbellSpiderCurl->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Держите грудь и плечи прижатыми к скамье на протяжении всего упражнения.',
    'Поднимайте гриф плавно, избегая рывков, и контролируйте опускание.',
    'Не позволяйте локтям смещаться в стороны или вперед.',
    'Используйте умеренный вес, чтобы поддерживать правильную технику и максимальную изоляцию бицепсов.'
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $ezBarbellSpiderCurl->tips()->attach($tip->id);
}

// Упражнение 1: Dumbbell Drag Biceps Curl
$dumbbellDragCurl = Exercise::create([
    'name' => 'Тяговое сгибание рук с гантелями',
    'video_url' => '/video/exercises/Dumbbell_Drag_Biceps_Curl.mp4',
    'thumbnail_url' => '/images/thumbnail/Dumbbell_Drag_Biceps_Curl.jpg',
    'min_weight_male' => 5,
    'max_weight_male' => 25,
    'min_weight_female' => 3,
    'max_weight_female' => 12,
    'description' => 'Тяговое сгибание рук с гантелями — это вариация стандартного сгибания, где акцент переносится на пиковое сокращение бицепса за счет перемещения локтей назад, а не вперед. Такое положение минимизирует вовлечение других мышц и усиливает изоляцию бицепсов.',
]);

// Связь с мышцами
$muscleData = [
    'Руки' => 95,
    'Плечи' => 5,
];

foreach ($muscleData as $muscleName => $percentage) {
    $muscle = MusclePercentage::where('name', $muscleName)->first();
    if ($muscle) {
        $dumbbellDragCurl->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
    }
}

// Связь с фильтрами
$filters = ['Бицепс', 'Предплечья', 'Плечи'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $dumbbellDragCurl->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Во время выполнения тяните гантели вдоль туловища, при этом локти движутся назад.',
    'Держите корпус неподвижным, избегая раскачиваний.',
    'Контролируйте темп, особенно в негативной фазе.',
    'Используйте полную амплитуду, но не допускайте перегрузки локтей.',
];

foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $dumbbellDragCurl->tips()->attach($tip->id);
}

// Упражнение: Cable Hammer Curl
$cableHammerCurl = Exercise::create([
    'name' => 'Сгибание рук на блоке "молотком"',
    'video_url' => '/video/exercises/Cable_Hammer_Curl.mp4',
    'thumbnail_url' => '/images/thumbnail/Cable_Hammer_Curl.jpg',
    'min_weight_male' => 10,
    'max_weight_male' => 40,
    'min_weight_female' => 5,
    'max_weight_female' => 20,
    'description' => 'Сгибание рук на блоке "молотком" — это упражнение, которое акцентирует нагрузку на бицепсы, предплечья и плечевые мышцы, благодаря нейтральному хвату. Использование троса обеспечивает постоянное напряжение на протяжении всего движения.',
]);

// Связь с мышцами
$musclePercentages = [
    ['name' => 'Руки', 'percentage' => 90],
    ['name' => 'Плечи', 'percentage' => 10],
];
foreach ($musclePercentages as $muscle) {
    $muscleEntity = MusclePercentage::where('name', $muscle['name'])->first();
    if ($muscleEntity) {
        $cableHammerCurl->musclePercentages()->attach($muscleEntity->id, ['percentages' => $muscle['percentage']]);
    }
}

// Связь с фильтрами
$filters = ['Бицепс', 'Предплечья', 'Плечи'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $cableHammerCurl->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Убедитесь, что локти остаются неподвижными и прижаты к туловищу.',
    'Держите трос рукояти параллельно друг другу для сохранения правильного нейтрального хвата.',
    'Выполняйте упражнение медленно, контролируя как подъем, так и опускание.',
    'Настройте блок на нужную высоту для оптимальной амплитуды движения.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $cableHammerCurl->tips()->attach($tip->id);
}

// Упражнение: Cable Overhead Curl
$cableOverheadCurl = Exercise::create([
    'name' => 'Сгибание рук на верхнем блоке над головой',
    'video_url' => '/video/exercises/Cable_Overhead_Curl.mp4',
    'thumbnail_url' => '/images/thumbnail/Cable_Overhead_Curl.jpg',
    'min_weight_male' => 10,
    'max_weight_male' => 30,
    'min_weight_female' => 5,
    'max_weight_female' => 15,
    'description' => 'Сгибание рук на верхнем блоке над головой — изолированное упражнение для бицепсов, выполняемое в положении, при котором мышцы находятся в максимальном растяжении в начале движения. Оно помогает акцентировать внимание на верхней части бицепса и улучшить его форму.',
]);

// Связь с мышцами
$arms = MusclePercentage::where('name', 'Руки')->first();
if ($arms) {
    $cableOverheadCurl->musclePercentages()->attach($arms->id, ['percentages' => 100]);
}

// Связь с фильтрами
$filters = ['Бицепс', 'Предплечья'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $cableOverheadCurl->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Держите локти на уровне плеч, неподвижными на протяжении всего упражнения.',
    'Используйте плавное, контролируемое движение, избегая рывков.',
    'Настройте высоту блоков так, чтобы обеспечить максимальную амплитуду.',
    'Следите за стабильностью корпуса, не прогибайте спину во время выполнения.'
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $cableOverheadCurl->tips()->attach($tip->id);
}

// Упражнение 2: Barbell Drag Curl
$barbellDragCurl = Exercise::create([
    'name' => 'Тяговое сгибание рук со штангой',
    'video_url' => '/video/exercises/Barbell_Drag_Curl.mp4',
    'thumbnail_url' => '/images/thumbnail/Barbell_Drag_Curl.jpg',
    'min_weight_male' => 20,
    'max_weight_male' => 50,
    'min_weight_female' => 10,
    'max_weight_female' => 25,
    'description' => 'Тяговое сгибание рук со штангой — это вариация стандартного сгибания, которая увеличивает акцент на бицепсах за счет движения локтей назад. Такое выполнение исключает возможность читинга и усиливает изоляцию мышц.',
]);

// Связь с мышцами
$muscles = [
    'Руки' => 95,
    'Плечи' => 5,
];

foreach ($muscles as $muscleName => $percentage) {
    $muscle = MusclePercentage::where('name', $muscleName)->first();
    if ($muscle) {
        $barbellDragCurl->musclePercentages()->attach($muscle->id, ['percentages' => $percentage]);
    }
}

// Связь с фильтрами
$filters = ['Бицепс', 'Предплечья', 'Плечи'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $barbellDragCurl->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Тяните штангу вдоль тела, локти при этом должны двигаться назад.',
    'Держите корпус неподвижным, избегая раскачиваний.',
    'Контролируйте каждую фазу движения, особенно негативную.',
    'Не блокируйте локти в нижней точке, чтобы сохранять постоянное напряжение в мышцах.'
];

foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $barbellDragCurl->tips()->attach($tip->id);
}

// Упражнение 2: Cable Kneeling Crunch
$cableKneelingCrunch = Exercise::create([
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
$musclePress = MusclePercentage::where('name', 'Пресс')->first();
if ($musclePress) {
    $cableKneelingCrunch->musclePercentages()->attach($musclePress->id, ['percentages' => 90]);
}

$muscleBack = MusclePercentage::where('name', 'Спина')->first();
if ($muscleBack) {
    $cableKneelingCrunch->musclePercentages()->attach($muscleBack->id, ['percentages' => 10]);
}

// Связь с фильтрами
$filters = ['Пресс', 'Трапеции'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $cableKneelingCrunch->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Держите корпус стабилизированным, избегайте лишнего движения в пояснице.',
    'Используйте технику скручивания, а не просто сгибания корпуса.',
    'Сосредотачивайтесь на напряжении пресса, не создавая напряжения в шее или спине.',
    'Плавно возвращайтесь в исходное положение, не расслабляя мышцы пресса.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $cableKneelingCrunch->tips()->attach($tip->id);
}

// Упражнение 1: Lever Ab Swing
$leverAbSwing = Exercise::create([
    'name' => 'Скручивания на тренажере для пресса',
    'video_url' => '/video/exercises/Lever_Ab_Swing.mp4',
    'thumbnail_url' => '/images/thumbnail/Lever_Ab_Swing.jpg',
    'min_weight_male' => 10,
    'max_weight_male' => 80,
    'min_weight_female' => 5,
    'max_weight_female' => 40,
    'description' => 'Скручивания на тренажере для пресса (Lever Ab Swing) — это упражнение, которое акцентирует нагрузку на мышцы кора, особенно на верхнюю и среднюю часть пресса. Использование тренажера помогает контролировать движение и изолировать работу пресса.',
]);

// Связь с мышцами
$abs = MusclePercentage::where('name', 'Пресс')->first();
if ($abs) {
    $leverAbSwing->musclePercentages()->attach($abs->id, ['percentages' => 100]);
}

// Связь с фильтрами
$filters = ['Пресс'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $leverAbSwing->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Держите спину прямой, избегайте прогибов в пояснице.',
    'Включайте только мышцы пресса, а не ноги или спину.',
    'Не наклоняйтесь слишком сильно вперед, чтобы избежать чрезмерного напряжения в спине.',
    'Контролируйте движение, плавно возвращая туловище в исходную позицию.'
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $leverAbSwing->tips()->attach($tip->id);
}

// Упражнение 1: Weighted Decline Crunch
$weightedDeclineCrunch = Exercise::create([
    'name' => 'Скручивания на наклонной скамье с весом',
    'video_url' => '/video/exercises/Weighted_Decline_Crunch.mp4',
    'thumbnail_url' => '/images/thumbnail/Weighted_Decline_Crunch.jpg',
    'min_weight_male' => 10,
    'max_weight_male' => 50,
    'min_weight_female' => 5,
    'max_weight_female' => 25,
    'description' => 'Скручивания на наклонной скамье с весом — эффективное упражнение для проработки верхней и средней части пресса. Наклон скамьи увеличивает амплитуду движения, что позволяет более интенсивно работать с мышцами живота. Дополнительный вес добавляет нагрузку, что способствует улучшению силы и формы пресса.',
]);

// Связь с мышцами
$abs = MusclePercentage::where('name', 'Пресс')->first();
if ($abs) {
    $weightedDeclineCrunch->musclePercentages()->attach($abs->id, ['percentages' => 100]);
}

// Связь с фильтрами
$filters = ['Пресс'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $weightedDeclineCrunch->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Поднимайте туловище медленно, сосредотачиваясь на напряжении в мышцах пресса.',
    'Держите ноги надежно зафиксированными, чтобы избежать читинга.',
    'Не напрягайте шею, держите голову нейтрально.',
    'Следите за тем, чтобы движение было исключительно из пресса, избегая вовлечения бедер или бедренных сгибателей.'
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $weightedDeclineCrunch->tips()->attach($tip->id);
}

// Упражнение 2: Dumbbell Russian Twist with Legs Floor Off
$dumbbellRussianTwist = Exercise::create([
    'name' => 'Русский твист с гантелью и ногами от пола',
    'video_url' => '/video/exercises/Dumbbell_Russian_Twist_with_Legs_Floor_Off.mp4',
    'thumbnail_url' => '/images/thumbnail/Dumbbell_Russian_Twist_with_Legs_Floor_Off.jpg',
    'min_weight_male' => 5,
    'max_weight_male' => 25,
    'min_weight_female' => 3,
    'max_weight_female' => 15,
    'description' => 'Русский твист с гантелью и ногами от пола — упражнение для пресса, которое акцентирует нагрузку на косые мышцы живота и верхний пресс. Поднятие ног с пола увеличивает сложность, заставляя работать больше стабилизирующих мышц. Использование гантели добавляет интенсивности упражнению.',
]);

// Связь с мышцами
$muscleGroups = [
    ['name' => 'Пресс', 'percentages' => 85],
    ['name' => 'Спина', 'percentages' => 10],
    ['name' => 'Руки', 'percentages' => 5],
];

foreach ($muscleGroups as $muscleData) {
    $muscle = MusclePercentage::where('name', $muscleData['name'])->first();
    if ($muscle) {
        $dumbbellRussianTwist->musclePercentages()->attach($muscle->id, ['percentages' => $muscleData['percentages']]);
    }
}

// Связь с фильтрами
$filters = ['Пресс', 'Трапеции', 'Бицепс'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $dumbbellRussianTwist->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Держите корпус в наклоне, не округляя спину.',
    'Вращайте туловище в обе стороны, избегая вращения только руками.',
    'Ноги должны быть подняты на небольшую высоту, чтобы увеличить нагрузку на пресс.',
    'Используйте медленный и контролируемый темп, чтобы удерживать постоянное напряжение в мышцах живота.'
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $dumbbellRussianTwist->tips()->attach($tip->id);
}

// Упражнение: Lever Total Abdominal Crunch
$leverTotalAbCrunch = Exercise::create([
    'name' => 'Скручивания на тренажере для всего пресса',
    'video_url' => '/video/exercises/Lever_Total_Abdominal_Crunch.mp4',
    'thumbnail_url' => '/images/thumbnail/Lever_Total_Abdominal_Crunch.jpg',
    'min_weight_male' => 10,
    'max_weight_male' => 80,
    'min_weight_female' => 5,
    'max_weight_female' => 40,
    'description' => 'Скручивания на тренажере для всего пресса — это эффективное упражнение, направленное на проработку всех частей пресса, включая верхнюю, среднюю и нижнюю. Использование тренажера позволяет изолировать мышцы пресса и минимизировать вовлечение других групп мышц, обеспечивая стабильное и контролируемое выполнение движения.',
]);

// Связь с мышцами
$absMuscle = MusclePercentage::where('name', 'Пресс')->first();
if ($absMuscle) {
    $leverTotalAbCrunch->musclePercentages()->attach($absMuscle->id, ['percentages' => 100]);
}

// Связь с фильтрами
$filters = ['Пресс'];
foreach ($filters as $filterName) {
    $filter = MuscleFilter::where('name', $filterName)->first();
    if ($filter) {
        $leverTotalAbCrunch->muscleFilters()->attach($filter->id);
    }
}

// Добавление советов
$tips = [
    'Сосредотачивайтесь на сокращении мышц пресса, избегая чрезмерного напряжения в шее.',
    'Плавно возвращайте туловище в исходную позицию, чтобы не расслабить мышцы пресса.',
    'Контролируйте амплитуду движения, не перегибая спину слишком сильно.',
    'Используйте правильную настройку тренажера, чтобы обеспечить полный диапазон движения.',
];
foreach ($tips as $tipContent) {
    $tip = Tip::create(['content' => $tipContent]);
    $leverTotalAbCrunch->tips()->attach($tip->id);
}

}
}
