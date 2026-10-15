<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admissions', function (Blueprint $table) {
            $table->string('roll_number', 30)->nullable()->unique()->after('status');
            $table->json('verified_documents')->nullable()->after('roll_number');
            $table->text('internal_notes')->nullable()->after('verified_documents');
            $table->timestamp('status_updated_at')->nullable()->after('internal_notes');
            $table->unsignedBigInteger('status_updated_by')->nullable()->after('status_updated_at');
            $table->index('status');
        });

        // History of every status change (who, when, why).
        Schema::create('admission_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admission_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('from_status', 30)->nullable();
            $table->string('to_status', 30);
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admission_logs');

        Schema::table('admissions', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropUnique(['roll_number']);
            $table->dropColumn(['roll_number', 'verified_documents', 'internal_notes', 'status_updated_at', 'status_updated_by']);
        });
    }
};
