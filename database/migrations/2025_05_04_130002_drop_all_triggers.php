<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Xóa tất cả trigger cũ
        DB::statement('DROP TRIGGER IF EXISTS check_borrow_limit_trigger');
        DB::statement('DROP TRIGGER IF EXISTS check_borrow_limit_update_trigger');
        DB::statement('DROP TRIGGER IF EXISTS check_unique_borrow_trigger');
        DB::statement('DROP TRIGGER IF EXISTS check_unique_borrow_update_trigger');
        DB::statement('DROP TRIGGER IF EXISTS check_duplicate_borrow_trigger');
        DB::statement('DROP TRIGGER IF EXISTS check_duplicate_borrow_update_trigger');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Không cần làm gì khi rollback
    }
}; 