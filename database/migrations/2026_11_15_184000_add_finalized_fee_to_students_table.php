<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Final net fee agreed for this individual student. It is not inherited from a class.
            $table->decimal('finalized_fee', 10, 2)->nullable()->after('monthly_tuition_fee');
        });

        // Keep existing active student fee plans by copying their final payable amount.
        if (Schema::hasTable('fee_plans')) {
            $activePlans = DB::table('fee_plans')
                ->where('status', 'active')
                ->get(['student_id', 'net_fee']);

            foreach ($activePlans as $plan) {
                DB::table('students')
                    ->where('id', $plan->student_id)
                    ->update(['finalized_fee' => $plan->net_fee]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('finalized_fee');
        });
    }
};
