<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['title','author','isbn','publisher','published_year','cover_image','description'];
    // Many-to-Many: 1 buku bisa punya banyak kategori, dan sebaliknya
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category', 'book_id', 'category_id');
    }

    // One-to-Many: 1 judul buku bisa punya banyak eksemplar fisik
    public function copies()
    {
        return $this->hasMany(BookCopy::class);
    }

    // One-to-Many: 1 judul buku bisa punya banyak reservasi
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}   
