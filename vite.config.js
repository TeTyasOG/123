import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/addExercise.css', 
                'resources/css/addProgram.css',
                'resources/css/app.css',
                'resources/css/auth.css',
                'resources/css/exercise.css',
                'resources/css/exercises.css',
                'resources/css/measurements.css',
                'resources/css/profile_settings.css',
                'resources/css/profile.css',
                'resources/css/shop.css',
                'resources/css/styles.css',
                'resources/css/training.css',
                'resources/css/workout_detail.css',
                'resources/css/workout.css',
                'resources/css/workouts.css',
                'resources/css/register.css',
               
                'resources/sass/app.scss',
                'resources/sass/register.scss',
                
                'resources/js/addExercise.js', 
                'resources/js/addProgram.js',
                'resources/js/app.js', 
                'resources/js/auth.js', 
                'resources/js/exercise.js', 
                'resources/js/measurements.js', 
                'resources/js/profile_settings.js', 
                'resources/js/profile.js', 
                'resources/js/shop.js', 
                'resources/js/styles.js', 
                'resources/js/training.js', 
                'resources/js/workout_detail.js', 
                'resources/js/workout.js', 
                'resources/js/workouts.js', 
                'resources/js/register.js'

                
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0', // или '134.209.197.54'
        port: 5173,
        hmr: {
            host: '134.209.197.54',
        },
    },
});
