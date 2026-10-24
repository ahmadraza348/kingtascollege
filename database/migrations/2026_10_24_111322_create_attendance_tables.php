<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Days the school is closed (weekends come from config/attendance.php).
        Schema::create('school_holidays', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->string('title', 150);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        // "Attendance was taken for this section on this day" + who/when. Separates "not taken" from "all present".
        Schema::create('attendance_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_class_id')->constrained('school_classes')->restrictOnDelete();
            $table->foreignId('section_id')->constrained('sections')->restrictOnDelete();
            $table->date('date');
            $table->unsignedBigInteger('marked_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->unique(['section_id', 'date']);
            $table->index('date');
        });

        // One row per student per day. Class/section are a snapshot of that day,
        // so promoting a student never rewrites history.
        Schema::create('attendance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('school_class_id')->constrained('school_classes')->restrictOnDelete();
            $table->foreignId('section_id')->constrained('sections')->restrictOnDelete();
            $table->date('date');
            $table->string('status', 12); // present, absent, late, excused, half_day
            $table->unsignedBigInteger('marked_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'date']);
            $table->index(['section_id', 'date']);
            $table->index(['school_class_id', 'date']);
            $table->index(['date', 'status']);
        });

        // Monthly totals per student and section, refreshed on every save. Makes charts and comparisons fast.
        Schema::create('attendance_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('school_class_id')->constrained('school_classes')->restrictOnDelete();
            $table->foreignId('section_id')->constrained('sections')->restrictOnDelete();
            $table->unsignedSmallInteger('year');
            $table->unsignedTinyInteger('month');
            $table->unsignedSmallInteger('present')->default(0);
            $table->unsignedSmallInteger('absent')->default(0);
            $table->unsignedSmallInteger('late')->default(0);
            $table->unsignedSmallInteger('excused')->default(0);
            $table->unsignedSmallInteger('half_day')->default(0);
            $table->unsignedSmallInteger('marked')->default(0);
            $table->decimal('percentage', 5, 2)->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'section_id', 'year', 'month']);
            $table->index(['year', 'month', 'school_class_id']);
            $table->index(['year', 'month', 'section_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_summaries');
        Schema::dropIfExists('attendance_logs');
        Schema::dropIfExists('attendance_sessions');
        Schema::dropIfExists('school_holidays');
    }
};