<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();
            $table->integer('position');
            $table->string('name');
            $table->string('type');
            $table->string('description');
            $table->string('menu_effect')->nullable();
            $table->integer('value');
            $table->integer('price')->nullable();
            $table->integer('sell_high');
            $table->integer('haggle')->nullable();
            $table->boolean('used_in_menu');
            $table->boolean('used_in_battle');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
