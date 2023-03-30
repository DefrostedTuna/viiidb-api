<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_status_effect', function (Blueprint $table) {
            $table->uuid('item_id');
            $table->uuid('status_effect_id');

            $table->unique(['item_id', 'status_effect_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_status_effects');
    }
};
