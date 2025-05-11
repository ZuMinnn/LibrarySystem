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

        // Tạo trigger kiểm tra việc mượn lại cùng một cuốn sách
        DB::statement('
            CREATE TRIGGER check_duplicate_borrow_trigger
            BEFORE INSERT ON borrows
            FOR EACH ROW
            BEGIN
                IF EXISTS (
                    SELECT 1 
                    FROM borrows 
                    WHERE user_id = NEW.user_id 
                    AND book_id = NEW.book_id 
                    AND status NOT IN ("returned", "rejected")
                ) THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "User has already borrowed this book and not returned it yet";
                END IF;
            END;
        ');

        DB::statement('
            CREATE TRIGGER check_duplicate_borrow_update_trigger
            BEFORE UPDATE ON borrows
            FOR EACH ROW
            BEGIN
                IF NEW.status NOT IN ("returned", "rejected") THEN
                    IF EXISTS (
                        SELECT 1 
                        FROM borrows 
                        WHERE user_id = NEW.user_id 
                        AND book_id = NEW.book_id 
                        AND status NOT IN ("returned", "rejected")
                        AND id != NEW.id
                    ) THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "User has already borrowed this book and not returned it yet";
                    END IF;
                END IF;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP TRIGGER IF EXISTS check_duplicate_borrow_trigger');
        DB::statement('DROP TRIGGER IF EXISTS check_duplicate_borrow_update_trigger');
    }
}; 