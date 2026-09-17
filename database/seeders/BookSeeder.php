<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $booksData = [
            [
                'isbn' => '9789792248904',
                'title' => 'Ayat-Ayat Cinta',
                'author' => 'Habiburrahman El Shirazy',
                'publisher' => 'Republika',
                'published_year' => 2004,
                'description' => 'Kisah cinta dan perjuangan seorang mahasiswa Indonesia di Mesir yang menghadapi dilema antara nilai-nilai agama dan kehidupan modern.',
                'categories' => ['Fiksi', 'Remaja'],
            ],
            [
                'isbn' => '9786020334843',
                'title' => 'Negeri 5 Menara',
                'author' => 'Ahmad Fuadi',
                'publisher' => 'Gramedia Pustaka Utama',
                'published_year' => 2009,
                'description' => 'Perjalanan enam santri di sebuah pesantren yang belajar meraih mimpi besar mereka masing-masing dari balik dinding madrasah.',
                'categories' => ['Fiksi', 'Pendidikan'],
            ],
            [
                'isbn' => '9789799731234',
                'title' => 'Sapiens: Riwayat Singkat Umat Manusia',
                'author' => 'Yuval Noah Harari',
                'publisher' => 'Kepustakaan Populer Gramedia',
                'published_year' => 2017,
                'description' => 'Menelusuri sejarah evolusi manusia dari zaman batu hingga era modern, membahas revolusi kognitif, pertanian, dan teknologi.',
                'categories' => ['Sains', 'Sejarah'],
            ],
            [
                'isbn' => '9786020326999',
                'title' => 'Filosofi Teras',
                'author' => 'Henry Manampiring',
                'publisher' => 'Kompas',
                'published_year' => 2018,
                'description' => 'Pengantar filsafat Stoa yang dikemas ringan untuk membantu pembaca mengelola emosi dan menjalani hidup dengan lebih tenang.',
                'categories' => ['Pendidikan', 'Remaja'],
            ],
            [
                'isbn' => '9789792247310',
                'title' => 'Laut Bercerita',
                'author' => 'Leila S. Chudori',
                'publisher' => 'Kepustakaan Populer Gramedia',
                'published_year' => 2017,
                'description' => 'Kisah aktivis mahasiswa yang hilang pada masa Orde Baru, dituturkan lewat sudut pandang dirinya dan keluarga yang ditinggalkan.',
                'categories' => ['Fiksi', 'Sejarah'],
            ],
            [
                'isbn' => '9786024246756',
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'publisher' => 'Gramedia Pustaka Utama',
                'published_year' => 2019,
                'description' => 'Panduan praktis membangun kebiasaan baik dan menghilangkan kebiasaan buruk lewat perubahan kecil yang konsisten.',
                'categories' => ['Pendidikan'],
            ],
            [
                'isbn' => '9789794338287',
                'title' => 'Cantik Itu Luka',
                'author' => 'Eka Kurniawan',
                'publisher' => 'Gramedia Pustaka Utama',
                'published_year' => 2002,
                'description' => 'Saga keluarga yang memadukan realisme magis dengan sejarah kelam Indonesia, berpusat pada seorang wanita yang bangkit dari kubur.',
                'categories' => ['Fiksi', 'Sejarah'],
            ],
            [
                'isbn' => '9786020632321',
                'title' => 'Sejarah Dunia yang Disederhanakan',
                'author' => 'Ernst H. Gombrich',
                'publisher' => 'Bentang Pustaka',
                'published_year' => 2016,
                'description' => 'Ringkasan perjalanan sejarah dunia dari zaman prasejarah hingga abad modern, ditulis dengan gaya yang mudah dipahami.',
                'categories' => ['Sejarah', 'Pendidikan'],
            ],
            [
                'isbn' => '9786029396084',
                'title' => 'Kalkulus Dasar',
                'author' => 'Purcell & Varberg',
                'publisher' => 'Erlangga',
                'published_year' => 2010,
                'description' => 'Buku ajar kalkulus untuk mahasiswa tingkat awal, mencakup limit, turunan, integral, dan aplikasinya dalam sains.',
                'categories' => ['Sains', 'Pendidikan'],
            ],
            [
                'isbn' => '9789799102456',
                'title' => 'Bumi Cinta',
                'author' => 'Habiburrahman El Shirazy',
                'publisher' => 'Republika',
                'published_year' => 2010,
                'description' => 'Perjalanan spiritual seorang mahasiswa Indonesia di Rusia yang bergulat dengan godaan sekularisme dan mempertahankan imannya.',
                'categories' => ['Fiksi', 'Sastra'],
            ],
        ];

        foreach ($booksData as $data) {
            $categoryNames = $data['categories'];
            unset($data['categories']);

            $book = Book::firstOrCreate(
                ['isbn' => $data['isbn']],
                $data
            );

            $categoryIds = Category::whereIn('name', $categoryNames)->pluck('id');
            $book->categories()->sync($categoryIds);
        }
    }
}
