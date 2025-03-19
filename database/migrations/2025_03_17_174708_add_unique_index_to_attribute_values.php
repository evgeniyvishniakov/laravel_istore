<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueIndexToAttributeValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attribute_values', function (Blueprint $table) {
            $table->unique(['attribute_id', 'name']);
        });
    }

    public function down()
    {
        Schema::table('attribute_values', function (Blueprint $table) {
            $table->dropUnique(['attribute_id', 'name']);
        });
    }
}
