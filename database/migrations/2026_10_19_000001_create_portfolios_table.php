<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('full_name');
            $table->string('email')->nullable();
            $table->string('phone', 40)->nullable();
            $table->string('address')->nullable();
            $table->text('about')->nullable();
            $table->longText('photo_url')->nullable();   // resized picture stored as an image data URL
            $table->jsonb('skills')->nullable();
            $table->jsonb('education')->nullable();
            $table->jsonb('projects')->nullable();
            $table->jsonb('experience')->nullable();
            $table->jsonb('links')->nullable();
            $table->string('template', 20)->default('simple');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
