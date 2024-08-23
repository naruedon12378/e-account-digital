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
        Schema::create('setting_classification_groups', function (Blueprint $table) {
            $table->id();
            $table->string('classification_code');
            $table->string('name');
            $table->string('description')->nullable();
            $table->tinyInteger('publish_income')->comment('เปิดเผยรายได้ (0,1)');
            $table->tinyInteger('publish_expense')->comment('เปิดเผยรายจ่าย (0,1)');
            $table->boolean('publish')->default(1)->comment('สถานะการเผยแพร่ (0, 1)');
            $table->boolean('record_status')->default(1)->comment('soft delete (0, 1)');
            $table->integer('company_id')->comment('FK บริษัท')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_classification_groups');
    }
};
