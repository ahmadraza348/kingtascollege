<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // A student's fee plan: the total payable fee and how it is split into installments.
        // Every installment is a normal fee voucher (fee_vouchers.fee_plan_id), so payments,
        // receipts and late fees keep working exactly as before.
        Schema::create('fee_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->restrictOnDelete();
            $table->string('session', 20)->nullable();
            $table->decimal('total_fee', 10, 2);              // fee before discount
            $table->decimal('discount', 10, 2)->default(0);   // scholarship / concession
            $table->decimal('net_fee', 10, 2);                // total payable = total_fee - discount
            $table->string('notes', 255)->nullable();
            $table->string('status', 10)->default('active');  // active, cancelled
            $table->timestamp('cancelled_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->index(['student_id', 'status']);
        });

        Schema::table('fee_vouchers', function (Blueprint $table) {
            $table->foreignId('fee_plan_id')->nullable()->after('student_id')->constrained('fee_plans')->restrictOnDelete();
            $table->unsignedSmallInteger('installment_no')->nullable()->after('fee_plan_id');
            $table->index(['fee_plan_id', 'status', 'due_date']);
        });
    }

    public function down(): void
    {
        Schema::table('fee_vouchers', function (Blueprint $table) {
            $table->dropConstrainedForeignId('fee_plan_id');
            $table->dropColumn('installment_no');
        });

        Schema::dropIfExists('fee_plans');
    }
};
