<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCopy extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id', 
        'inventory_code', 
        'status'
    ];

    // Cast enum status supaya konsisten
    protected $casts = [
        'status' => 'string',
    ];

    // belongsTo: setiap eksemplar milik 1 judul buku
    // Contoh: BookCopy dengan inventory_code "BK-001-01" milik Book "Harry Potter"
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // hasMany: 1 eksemplar bisa punya banyak riwayat peminjaman
    // Contoh: eksemplar "BK-001-01" pernah dipinjam 5 kali → 5 record di loans
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
