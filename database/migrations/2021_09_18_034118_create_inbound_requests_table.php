<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInboundRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inbound_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('api_version')->nullable();
            $table->string('path')->nullable();
            $table->string('query_string')->nullable();
            $table->string('full_path')->nullable();
            $table->string('full_uri')->nullable();
            $table->json('headers')->nullable();
            $table->string('status_code')->nullable();
            $table->integer('duration')->nullable();
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
        Schema::dropIfExists('inbound_requests');
    }
}
