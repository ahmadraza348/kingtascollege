<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // The kinds of money the school spends (salaries, rent, electricity ...).
        Schema::create('expense_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        $now = now();
        $names = [
            'Salaries & Wages', 'Building Rent', 'Electricity', 'Gas', 'Water', 'Internet & Phone',
            'Stationery & Printing', 'Lab / Clinical Supplies', 'Repairs & Maintenance', 'Cleaning & Security',
            'Transport & Fuel', 'Events & Functions', 'Advertising & Marketing', 'Taxes & Government Fees',
            'Furniture & Equipment', 'Miscellaneous',
        ];
        DB::table('expense_categories')->insert(array_map(fn ($name, $i) => [
            'name' => $name, 'is_active' => true, 'sort_order' => $i + 1, 'created_at' => $now, 'updated_at' => $now,
        ], $names, array_keys($names)));

        // One expense = one bill the school has to pay (or has already paid).
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('expense_number', 30)->nullable()->unique();
            $table->foreignId('expense_category_id')->constrained('expense_categories')->restrictOnDelete();
            $table->string('title', 150);
            $table->string('payee', 150)->nullable();          // who is to be paid: vendor, landlord, teacher ...
            $table->string('reference_no', 60)->nullable();    // bill / invoice number
            $table->date('expense_date');                      // date of the bill
            $table->date('due_date')->nullable();              // last day to pay
            $table->decimal('amount', 12, 2);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->string('status', 10)->default('unpaid');   // unpaid, partial, paid, cancelled
            $table->text('description')->nullable();
            $table->string('attachment_path')->nullable();
            $table->string('attachment_name')->nullable();
            $table->string('submit_token', 40)->nullable()->unique(); // blocks a double click saving twice
            $table->string('status_reason', 255)->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->unsignedBigInteger('cancelled_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->index('expense_date');
            $table->index(['status', 'due_date']);
            $table->index('payee');
        });

        // Money actually paid out against an expense. Part payments are allowed.
        Schema::create('expense_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expense_id')->constrained('expenses')->cascadeOnDelete();
            $table->date('payment_date');
            $table->decimal('amount', 12, 2);
            $table->string('method', 15);                      // cash, bank_transfer, cheque, online
            $table->string('reference_no', 60)->nullable();    // cheque no / transaction id
            $table->string('remarks', 255)->nullable();
            $table->string('status', 10)->default('active');   // active, cancelled
            $table->string('cancel_reason', 255)->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->string('submit_token', 40)->nullable()->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->index(['expense_id', 'status']);
            $table->index('payment_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expense_payments');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('expense_categories');
    }
};
