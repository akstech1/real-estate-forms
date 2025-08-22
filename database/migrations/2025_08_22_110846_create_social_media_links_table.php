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
        Schema::create('social_media_links', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('link');
            $table->timestamps();
        });

        // Create pivot table for contact_us and social_media_links
        Schema::create('contact_us_social_media_link', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_us_id')->constrained('contact_us')->onDelete('cascade');
            $table->foreignId('social_media_link_id')->constrained('social_media_links')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_us_social_media_link');
        Schema::dropIfExists('social_media_links');
    }
};
