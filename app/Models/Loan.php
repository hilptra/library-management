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

    // Cast tipe data supaya Laravel otomatis convert
    // - date: string "2026-08-04" → Carbon object (bisa ->format(), ->diffInDays(), dll)
    // - decimal: string "10000.00" → float, presisi 2 angka di belakang koma
    protected $casts = [
        'loan_date'   => 'date',
        'due_date'    => 'date',
        'return_date' => 'date',
        'fine_amount' => 'decimal:2',
    ];

    // belongsTo: setiap peminjaman milik 1 user (anggota yang meminjam)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // belongsTo: setiap peminjaman terkait 1 eksemplar spesifik
    // Bukan ke Book langsung, tapi ke BookCopy — karena yang dipinjam itu eksemplar fisiknya
    public function bookCopy()
    {
        return $this->belongsTo(BookCopy::class);
    }
}
