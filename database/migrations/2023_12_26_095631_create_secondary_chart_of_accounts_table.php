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
        Schema::create('secondary_chart_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name_th');
            $table->string('name_en');
            $table->string('code');
            $table->float('sort')->nullable()->comment('ลำดับ');
            $table->boolean('publish')->default(1)->comment('สถานะการเผยแพร่ (0, 1)');
            $table->integer('main_chart_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secondary_chart_of_accounts');
    }
};
