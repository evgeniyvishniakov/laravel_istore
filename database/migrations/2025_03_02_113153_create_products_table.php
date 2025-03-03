<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('article', 100)->unique(); // не дает повторяться
            $table->text('description')->nullable(); // можно оставить пустим
            $table->integer('price');
            $table->integer('stock_quantity')->default(0);
            $table->boolean('is_available')->default(true);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            //$table->foreignId('category_id')->constrained('categories');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
