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
        Schema::create('package_has_feature_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('feature_list_id')->nullable()->comment('FK feature_lists');
            $table->unsignedBigInteger('package_id')->nullable()->comment('FK packages');

            $table->foreign('feature_list_id')->references('id')->on('feature_lists')->onDelete('cascade');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_has_feature_lists');
    }
};
