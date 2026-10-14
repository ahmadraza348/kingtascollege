<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();

            $table->string('name', 120);
            $table->string('phone', 30);
            $table->string('email', 150);
            $table->string('subject', 150);
            $table->string('program', 100)->nullable();
            $table->text('message');

            // false when the email to the college failed, so staff can follow up from the database.
            $table->boolean('email_sent')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
