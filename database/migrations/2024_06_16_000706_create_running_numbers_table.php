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
        Schema::create('running_numbers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('series_id');
            $table->integer('month01')->default(1);
            $table->integer('month02')->default(1);
            $table->integer('month03')->default(1);
            $table->integer('month04')->default(1);
            $table->integer('month05')->default(1);
            $table->integer('month06')->default(1);
            $table->integer('month07')->default(1);
            $table->integer('month08')->default(1);
            $table->integer('month09')->default(1);
            $table->integer('month10')->default(1);
            $table->integer('month11')->default(1);
            $table->integer('month12')->default(1);
            $table->string('year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('running_numbers');
    }
};
