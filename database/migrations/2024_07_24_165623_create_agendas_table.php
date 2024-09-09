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
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('duration_a')->nullable();
            $table->integer('duration_r');
            $table->string('ra_first')->default('a');
            $table->string('ra_second')->default('r');
            $table->string('created_by');
            $table->text('document')->nullable();
            $table->date('start_dt_a')->nullable();
            $table->date('start_dt_r');
            $table->date('end_dt_a')->nullable();
            $table->date('end_dt_r');
            $table->string('information')->nullable();
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('program_id');
            $table->string('sub');
            $table->timestamp('updated_date')->nullable();
            $table->timestamp('updated_actual')->nullable();
            $table->timestamps();

            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
