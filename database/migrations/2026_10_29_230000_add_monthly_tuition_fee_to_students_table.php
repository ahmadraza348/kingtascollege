<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // NULL means inherit the class/session Tuition Fee amount.
            // Zero is a valid explicit override (tuition waived for this student).
            $table->decimal('monthly_tuition_fee', 10, 2)->nullable()->after('session');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('monthly_tuition_fee');
        });
    }
};
