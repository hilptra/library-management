<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_copy_id',
        'loan_date',
        'due_date',
        'return_date',
        'fine_amount',
        'status',
    ];

    protected $casts = [
        'loan_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
        'fine_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookCopy()
    {
        return $this->belongsTo(BookCopy::class);
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'pending' => 'bg-amber-100 text-amber-800 border border-amber-200/60',
            'borrowed' => 'bg-blue-100 text-blue-800 border border-blue-200/60',
            'returned' => 'bg-emerald-100 text-emerald-800 border border-emerald-200/60',
            'rejected' => 'bg-rose-100 text-rose-800 border border-rose-200/60',
            'cancelled' => 'bg-slate-100 text-slate-600 border border-slate-200/60',
        };
    }

    public function calculateFine(): int
    {
        if (! $this->due_date) {
            return 0;
        }

        $compareDate = $this->return_date ?? now();

        if ($compareDate->lte($this->due_date)) {
            return 0;
        }

        $daysLate = (int) floor($this->due_date->diffInDays($compareDate));
        $finePerDay = (int) Setting::get('fine_per_day', 1000);

        return $daysLate * $finePerDay;
    }
}
