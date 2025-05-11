<?php

namespace App\Console\Commands;

use App\Models\Borrow;
use App\Mail\DueBookReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckDueBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:check-due';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kiểm tra sách sắp đến hạn trả và gửi thông báo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Bắt đầu kiểm tra sách sắp đến hạn trả...');

        // Lấy danh sách sách sắp đến hạn trả
        $borrows = Borrow::dueSoon()->get();

        if ($borrows->isEmpty()) {
            $this->info('Không có sách nào sắp đến hạn trả.');
            return;
        }

        $this->info('Tìm thấy ' . $borrows->count() . ' sách sắp đến hạn trả.');

        // Gửi thông báo cho từng người mượn
        foreach ($borrows as $borrow) {
            try {
                Mail::to($borrow->user->email)
                    ->send(new DueBookReminder($borrow));
                
                $borrow->markReminderSent();
                
                $this->info('Đã gửi thông báo cho: ' . $borrow->user->email);
            } catch (\Exception $e) {
                $this->error('Lỗi khi gửi thông báo cho ' . $borrow->user->email . ': ' . $e->getMessage());
            }
        }

        $this->info('Hoàn thành kiểm tra sách sắp đến hạn trả.');
    }
}
