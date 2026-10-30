<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->string('program', 100);
            $table->timestamps();

            $table->unique(['student_id', 'program']);
            $table->index('program');
        });

        // Preserve each existing student's current single program as their first linked program.
        $now = now();
        DB::table('students')
            ->whereNotNull('program')
            ->where('program', '<>', '')
            ->orderBy('id')
            ->chunk(500, function ($students) use ($now) {
                $rows = $students->map(fn ($student) => [
                    'student_id' => $student->id,
                    'program' => $student->program,
                    'created_at' => $now,
                    'updated_at' => $now,
                ])->all();

                if ($rows) {
                    DB::table('student_programs')->insertOrIgnore($rows);
                }
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_programs');
    }
};
