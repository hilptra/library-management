<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookCopy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buku Laskar Pelangi
        $buku1 = Book::create([
            'title'          => 'Laskar Pelangi',
            'author'         => 'Andrea Hirata',
            'isbn'           => '978-602-8346-56-0',
            'publisher'      => 'Bentang Pustaka',
            'published_year' => 2005,
            'cover_image'    => null,
            'description'    => 'Mengisahkan perjuangan 10 anak dari keluarga miskin di Belitung yang bersekolah di SD Muhammadiyah yang penuh keterbatasan, namun tetap memiliki semangat juang tinggi demi pendidikan.',
        ]);
        $buku1->categories()->attach([1, 7, 10]); // Fiksi, Sastra, Pendidikan
        BookCopy::create(['book_id' => $buku1->id, 'inventory_code' => 'BK-LP-001', 'status' => 'available']);
        BookCopy::create(['book_id' => $buku1->id, 'inventory_code' => 'BK-LP-002', 'status' => 'available']);
        BookCopy::create(['book_id' => $buku1->id, 'inventory_code' => 'BK-LP-003', 'status' => 'borrowed']);


        // 2. Buku Bumi Manusia
        $buku2 = Book::create([
            'title'          => 'Bumi Manusia',
            'author'         => 'Pramoedya Ananta Toer',
            'isbn'           => '978-979-97312-3-4',
            'publisher'      => 'Lentera Dipantara',
            'published_year' => 1980,
            'cover_image'    => null,
            'description'    => 'Novel sejarah yang mengisahkan perjuangan Minke, seorang pemuda pribumi di era kolonial Hindia Belanda, dalam mencari jati diri dan memperjuangkan hak-hak pribumi.',
        ]);
        $buku2->categories()->attach([1, 5, 7]); // Fiksi, Sejarah, Sastra

        BookCopy::create(['book_id' => $buku2->id, 'inventory_code' => 'BK-BM-001', 'status' => 'available']);
        BookCopy::create(['book_id' => $buku2->id, 'inventory_code' => 'BK-BM-002', 'status' => 'available']);

        // 3. Buku Filosofi Teras
        $buku3 = Book::create([
            'title'          => 'Filosofi Teras',
            'author'         => 'Henry Manampiring',
            'isbn'           => '978-602-424-694-5',
            'publisher'      => 'Penerbit Buku Kompas',
            'published_year' => 2018,
            'cover_image'    => null,
            'description'    => 'Penerapan praktis filsafat Stoisisme dalam kehidupan modern untuk membantu mengendalikan emosi negatif dan membangun mental yang tangguh.',
        ]);
        $buku3->categories()->attach([2, 10]); // Non-Fiksi, Pendidikan

        BookCopy::create(['book_id' => $buku3->id, 'inventory_code' => 'BK-FT-001', 'status' => 'available']);
        BookCopy::create(['book_id' => $buku3->id, 'inventory_code' => 'BK-FT-002', 'status' => 'available']);

        // 4. Buku Clean Code
        $buku4 = Book::create([
            'title'          => 'Clean Code: A Handbook of Agile Software Craftsmanship',
            'author'         => 'Robert C. Martin',
            'isbn'           => '978-013-235088-4',
            'publisher'      => 'Prentice Hall',
            'published_year' => 2008,
            'cover_image'    => null,
            'description'    => 'Panduan profesional rekayasa perangkat lunak yang mengajarkan cara menulis kode program yang bersih, efisien, dan mudah dipelihara.',
        ]);
        $buku4->categories()->attach([4, 10]); // Teknologi, Pendidikan

        BookCopy::create(['book_id' => $buku4->id, 'inventory_code' => 'BK-CC-001', 'status' => 'available']);
        BookCopy::create(['book_id' => $buku4->id, 'inventory_code' => 'BK-CC-002', 'status' => 'available']);
    }
}
