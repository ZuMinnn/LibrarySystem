<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('borrows', function (Blueprint $table) {
            if (!Schema::hasColumn('borrows', 'due_date')) {
                $table->date('due_date')->nullable();
            }
            if (!Schema::hasColumn('borrows', 'reminder_sent')) {
                $table->boolean('reminder_sent')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrows', function (Blueprint $table) {
            if (Schema::hasColumn('borrows', 'due_date')) {
                $table->dropColumn('due_date');
            }
            if (Schema::hasColumn('borrows', 'reminder_sent')) {
                $table->dropColumn('reminder_sent');
            }
        });
    }
};
