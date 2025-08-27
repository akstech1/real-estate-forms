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
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            
            // Header Section
            $table->text('header_description_ar')->nullable();
            $table->text('header_description_en')->nullable();
            
            // Platform Overview
            $table->text('platform_description_ar')->nullable();
            $table->text('platform_description_en')->nullable();
            
            // Our Mission
            $table->string('our_mission_heading_ar')->nullable();
            $table->string('our_mission_heading_en')->nullable();
            $table->text('our_mission_description_ar')->nullable();
            $table->text('our_mission_description_en')->nullable();
            $table->text('our_mission_vision_description_ar')->nullable();
            $table->text('our_mission_vision_description_en')->nullable();
            
            // Our Goals
            $table->text('our_goal_description_ar')->nullable();
            $table->text('our_goal_description_en')->nullable();
            
            // Home Section
            $table->text('home_short_description_ar');
            $table->text('home_short_description_en');
            $table->string('home_button_text_en');
            $table->string('home_button_text_ar');
            $table->string('home_button_link');
            $table->string('count');
            $table->string('count_heading_en');
            $table->string('count_heading_ar');
            $table->text('count_description_en');
            $table->text('count_description_ar');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
