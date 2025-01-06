<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModels extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Этот файл больше не создаёт коллекции,
        // так как они разделены на отдельные миграции.
        // Вы можете добавить сюда глобальные настройки, если это необходимо.
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Здесь можно оставить удаление глобальных настроек или других изменений,
        // если они добавлены в метод `up`.
    }
}
