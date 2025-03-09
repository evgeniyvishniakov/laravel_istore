<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropSlagAndAddSlugToCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Удаляем колонку slag
            $table->dropColumn('slag');

            // Добавляем колонку slug
            $table->string('slug')->nullable(); // Поле slug будет пустым по умолчанию
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Восстанавливаем колонку slag, если откатить миграцию
            $table->string('slag')->nullable();

            // Удаляем колонку slug
            $table->dropColumn('slug');
        });
    }
}
