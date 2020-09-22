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
            $table->integer('position')->nullable()->unique();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('description')->nullable();
            $table->string('menu_effect')->nullable();
            $table->integer('price')->nullable();
            $table->integer('value')->nullable();
            $table->integer('haggle')->nullable();
            $table->integer('sell_high')->nullable();
            $table->boolean('used_in_menu')->nullable();
            $table->boolean('used_in_battle')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
