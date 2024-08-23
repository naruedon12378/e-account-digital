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
        Schema::create('feature_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name_th')->nullable()->comment('รายละเอียดแต่ละ Feature');
            $table->string('name_en')->nullable()->comment('รายละเอียดแต่ละ Feature');
            $table->float('sort')->nullable()->comment('ลำดับ');
            $table->boolean('publish')->default(1)->comment('สถานะการเผยแพร่ (0, 1)');
            $table->unsignedBigInteger('feature_title_id')->nullable()->comment('FK feature_titles');

            $table->foreign('feature_title_id')->references('id')->on('feature_titles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feature_lists');
    }
};
