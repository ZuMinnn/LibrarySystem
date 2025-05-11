<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_id',
        'status',
        'due_date',
        'reminder_sent'
    ];

    protected $casts = [
        'due_date' => 'date',
        'reminder_sent' => 'boolean'
    ];

    // Scope để lấy các sách đang mượn
    public function scopeActive(Builder $query)
    {
        return $query->where('status', 'approved');
    }

    // Scope để lấy các sách sắp đến hạn trả
    public function scopeDueSoon(Builder $query, $days = 3)
    {
        return $query->where('status', 'approved')
            ->where('reminder_sent', false)
            ->whereDate('due_date', '<=', now()->addDays($days));
    }

    // Scope để lấy các sách đã quá hạn
    public function scopeOverdue(Builder $query)
    {
        return $query->where('status', 'approved')
            ->whereDate('due_date', '<', now());
    }

    // Kiểm tra xem sách có sắp đến hạn trả không
    public function isDueSoon($days = 3)
    {
        return $this->status === 'approved' 
            && !$this->reminder_sent 
            && $this->due_date->lte(now()->addDays($days));
    }

    // Kiểm tra xem sách có quá hạn không
    public function isOverdue()
    {
        return $this->status === 'approved' 
            && $this->due_date->lt(now());
    }

    // Đánh dấu đã gửi thông báo
    public function markReminderSent()
    {
        $this->update(['reminder_sent' => true]);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
