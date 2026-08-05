<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'reservation_date',
        'status',
    ];

    protected $casts = [
        'reservation_date' => 'date',
    ];

    // belongsTo: setiap reservasi milik 1 user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // belongsTo: reservasi itu untuk 1 judul buku (bukan eksemplar spesifik)
    // Bedanya dengan Loan: Loan → BookCopy (eksemplar), Reservation → Book (judul)
    // Karena saat reservasi, belum ditentukan eksemplar mana yang akan diberikan
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
