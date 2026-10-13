<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();

            // Personal information
            $table->string('full_name');
            $table->string('father_name');
            $table->date('date_of_birth');
            $table->string('gender', 30);
            $table->string('cnic', 25)->index();
            $table->string('phone', 30);
            $table->string('whatsapp', 30)->nullable();
            $table->string('email')->nullable();

            // Academic information
            $table->string('qualification', 100);
            $table->string('institution');
            $table->decimal('obtained_marks', 10, 2)->nullable();
            $table->decimal('total_marks', 10, 2)->nullable();
            $table->decimal('percentage', 5, 2)->nullable();

            // Program information
            $table->string('program');
            $table->string('session', 20)->default('2026–27');
            $table->text('notes')->nullable();

            // Address information
            $table->text('street');
            $table->string('city');
            $table->string('district')->nullable();
            $table->string('province')->nullable();

            // Uploaded document paths
            $table->string('cnic_front_path');
            $table->string('cnic_back_path');
            $table->string('domicile_document_path');
            $table->json('degree_documents')->nullable();
            $table->string('personal_picture_path');
            $table->json('other_documents')->nullable();

            // Application management
            $table->boolean('terms_accepted')->default(false);
            $table->string('status', 30)->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};