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
        
    }
}
