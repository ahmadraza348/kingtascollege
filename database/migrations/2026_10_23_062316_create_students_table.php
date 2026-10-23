<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            // Link to the online admission (optional: students can also be added manually).
            // Unique: one application can only become one student.
            $table->foreignId('admission_id')->nullable()->unique()->constrained('admissions')->nullOnDelete();
            $table->string('admission_form_number', 30)->nullable()->index();

            // Identity
            $table->string('roll_number', 30)->unique();
            $table->string('full_name', 120);
            $table->string('father_name', 120);
            $table->string('gender', 20);
            $table->date('date_of_birth')->nullable();
            $table->string('cnic', 25)->nullable()->index();   // CNIC or B-Form
            $table->string('blood_group', 5)->nullable();
            $table->string('photo_path')->nullable();           // relative to /public

            // Contact
            $table->string('phone', 30);
            $table->string('whatsapp', 30)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('guardian_name', 120)->nullable();
            $table->string('guardian_phone', 30)->nullable();

            // Address
            $table->string('street', 200)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('district', 100)->nullable();
            $table->string('province', 60)->nullable();

            // Previous education
            $table->string('qualification', 100)->nullable();
            $table->string('institution', 150)->nullable();
            $table->decimal('obtained_marks', 10, 2)->nullable();
            $table->decimal('total_marks', 10, 2)->nullable();
            $table->decimal('percentage', 5, 2)->nullable();

            // Placement in the college
            $table->foreignId('school_class_id')->constrained('school_classes')->restrictOnDelete();
            $table->foreignId('section_id')->constrained('sections')->restrictOnDelete();
            $table->string('program', 100)->nullable();
            $table->string('session', 20);
            $table->date('admission_date')->nullable();
            $table->string('status', 20)->default('active')->index(); // active, inactive, graduated, left

            $table->text('notes')->nullable();

            $table->softDeletes();
            $table->timestamps();

            // Used by the attendance screen: students of a section that are active.
            $table->index(['school_class_id', 'section_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};