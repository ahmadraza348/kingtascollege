<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Policies, bank details and voucher wording. Missing rows fall back to defaults in FeeSetting.
        Schema::create('fee_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60)->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // The kinds of money the college charges.
        Schema::create('fee_heads', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('code', 40)->unique();
            $table->string('frequency', 12)->default('monthly'); // monthly, one_time, per_exam, manual
            $table->string('kind', 10)->default('charge');       // charge, fine, arrears
            $table->boolean('is_system')->default(false);        // used by the policies, cannot change code
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        $now  = now();
        $head = fn ($name, $code, $frequency, $kind, $system, $sort) => [
            'name' => $name, 'code' => $code, 'frequency' => $frequency, 'kind' => $kind,
            'is_system' => $system, 'is_active' => true, 'sort_order' => $sort, 'created_at' => $now, 'updated_at' => $now,
        ];

        DB::table('fee_heads')->insert([
            $head('Tuition Fee', 'TUITION', 'monthly', 'charge', false, 1),
            $head('Admission Fee', 'ADMISSION', 'one_time', 'charge', false, 2),
            $head('Examination Fee', 'EXAM', 'per_exam', 'charge', false, 3),
            $head('Readmission Fee', 'READMISSION', 'manual', 'charge', true, 4),
            $head('Previous Dues (Opening Balance)', 'PREVIOUS_DUES', 'manual', 'arrears', true, 5),
            $head('Absent Fine', 'ABSENT_FINE', 'manual', 'fine', true, 6),
            $head('Late Fee', 'LATE_FEE', 'manual', 'fine', true, 7),
            $head('Duplicate Voucher Charge', 'DUPLICATE_VOUCHER', 'manual', 'fine', true, 8),
        ]);

        // What each class pays, per session.
        Schema::create('fee_structures', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->foreignId('school_class_id')->constrained('school_classes')->restrictOnDelete();
            $table->string('session', 20);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['school_class_id', 'session']);
        });

        Schema::create('fee_structure_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fee_structure_id')->constrained('fee_structures')->cascadeOnDelete();
            $table->foreignId('fee_head_id')->constrained('fee_heads')->restrictOnDelete();
            $table->decimal('amount', 10, 2);
            $table->timestamps();

            $table->unique(['fee_structure_id', 'fee_head_id']);
        });

        // A standing discount for one student on one fee head (sibling, merit, ...).
        Schema::create('fee_concessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('fee_head_id')->constrained('fee_heads')->restrictOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('reason', 200)->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'fee_head_id']);
        });

        // One voucher = one bill. It only holds its own charges; arrears are never copied into it.
        Schema::create('fee_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_number', 30)->nullable()->unique();
            $table->foreignId('student_id')->constrained('students')->restrictOnDelete();
            $table->foreignId('school_class_id')->constrained('school_classes')->restrictOnDelete(); // as on voucher day
            $table->foreignId('section_id')->constrained('sections')->restrictOnDelete();
            $table->string('roll_number', 30);
            $table->string('type', 12);                  // monthly, admission, exam, readmission, opening, other
            $table->string('period', 7);                 // billing month, 2026-10
            $table->string('unique_key', 60)->nullable(); // blocks duplicates; emptied when cancelled
            $table->date('issue_date');
            $table->date('due_date');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('balance', 10, 2)->default(0);
            $table->string('status', 10)->default('unpaid'); // unpaid, partial, paid, cancelled
            $table->boolean('late_fee_waived')->default(false);
            $table->unsignedSmallInteger('duplicate_count')->default(0);
            $table->unsignedSmallInteger('printed_count')->default(0);
            $table->string('notes', 255)->nullable();
            $table->string('cancel_reason', 255)->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->unsignedBigInteger('cancelled_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'unique_key']);
            $table->index('period');
            $table->index(['status', 'due_date']);
            $table->index(['school_class_id', 'section_id', 'period']);
        });

        // Lines of a voucher. Amount is signed: charges and fines are +, discounts and waivers are -.
        Schema::create('fee_voucher_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fee_voucher_id')->constrained('fee_vouchers')->cascadeOnDelete();
            $table->foreignId('fee_head_id')->nullable()->constrained('fee_heads')->restrictOnDelete();
            $table->string('title', 150);
            $table->decimal('amount', 10, 2);
            $table->string('source', 20); // structure, concession, absent_fine, late_fee, late_fee_waiver, duplicate, manual, discount, opening, readmission, other
            $table->date('charged_on');
            $table->string('note', 255)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->index(['fee_voucher_id', 'source']);
        });

        Schema::create('fee_payments', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number', 30)->nullable()->unique(); // only confirmed payments get a receipt
            $table->foreignId('student_id')->constrained('students')->restrictOnDelete();
            $table->date('payment_date');
            $table->string('method', 15);                 // cash, bank_deposit, online, cheque
            $table->decimal('amount', 10, 2);
            $table->string('bank_name', 100)->nullable();
            $table->string('branch', 100)->nullable();
            $table->string('reference_no', 60)->nullable(); // deposit slip / transaction / cheque number
            $table->string('dedupe_key', 64)->nullable()->unique();   // same bank + reference can only be entered once
            $table->string('submit_token', 40)->nullable()->unique(); // stops a double click saving twice
            $table->unsignedBigInteger('preferred_voucher_id')->nullable();
            $table->string('status', 10)->default('pending'); // pending, verified, rejected, cancelled
            $table->decimal('balance_after', 10, 2)->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->string('status_reason', 255)->nullable();
            $table->string('remarks', 255)->nullable();
            $table->unsignedBigInteger('received_by')->nullable();
            $table->timestamps();

            $table->index(['status', 'payment_date']);
        });

        // Which voucher each verified payment paid, and how much.
        Schema::create('fee_payment_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fee_payment_id')->constrained('fee_payments')->cascadeOnDelete();
            $table->foreignId('fee_voucher_id')->constrained('fee_vouchers')->restrictOnDelete();
            $table->decimal('amount', 10, 2);
            $table->timestamps();

            $table->unique(['fee_payment_id', 'fee_voucher_id']);
        });

        // Who did what, when. Nothing here is ever edited.
        Schema::create('fee_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->nullable()->index();
            $table->unsignedBigInteger('fee_voucher_id')->nullable()->index();
            $table->unsignedBigInteger('fee_payment_id')->nullable()->index();
            $table->string('action', 30);
            $table->string('description', 500);
            $table->decimal('amount', 10, 2)->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        foreach (['fee_audit_logs', 'fee_payment_allocations', 'fee_payments', 'fee_voucher_items', 'fee_vouchers',
                  'fee_concessions', 'fee_structure_items', 'fee_structures', 'fee_heads', 'fee_settings'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};