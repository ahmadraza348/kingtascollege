<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fee_voucher_items', function (Blueprint $table) {
            // Used when a late fine is billed on a later monthly voucher, not on the overdue voucher.
            $table->foreignId('origin_fee_voucher_id')
                ->nullable()
                ->after('fee_voucher_id')
                ->constrained('fee_vouchers')
                ->restrictOnDelete();

            $table->index(['origin_fee_voucher_id', 'source'], 'fee_voucher_items_origin_source_idx');
        });
    }

    public function down(): void
    {
        Schema::table('fee_voucher_items', function (Blueprint $table) {
            $table->dropIndex('fee_voucher_items_origin_source_idx');
            $table->dropConstrainedForeignId('origin_fee_voucher_id');
        });
    }
};
