<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('caption')->nullable();
            $table->string('image_path')->nullable();
            $table->string('category')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(false);
            $table->timestamps();

            $table->index('category');
            $table->index('is_published');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_items');
    }
};
