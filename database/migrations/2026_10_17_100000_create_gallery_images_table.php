<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();

            // Optional caption shown on the website gallery.
            $table->string('title', 150)->nullable();

            // Path relative to the /public folder, e.g. uploads/gallery/abc.jpg
            $table->string('image_path');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_images');
    }
};
