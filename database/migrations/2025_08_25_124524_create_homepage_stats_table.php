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
        Schema::create('homepage_stats', function (Blueprint $table) {
            $table->id();
            $table->string('section_1_heading_en');
            $table->string('section_1_heading_ar');
            $table->string('section_1_count');
            $table->string('section_2_heading_en');
            $table->string('section_2_heading_ar');
            $table->string('section_2_count');
            $table->string('section_3_heading_en');
            $table->string('section_3_heading_ar');
            $table->string('section_3_count');
            $table->string('section_4_heading_en');
            $table->string('section_4_heading_ar');
            $table->string('section_4_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepage_stats');
    }
};
