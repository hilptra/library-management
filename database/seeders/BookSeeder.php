<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'isbn' => '9786022916628',
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'publisher' => 'Bentang Pustaka',
                'published_year' => '2005',
                'description' => 'Laskar Pelangi adalah novel karya Andrea Hirata yang menceritakan kehidupan sepuluh anak dari keluarga sederhana di Belitung yang bersekolah di SD Muhammadiyah dengan berbagai keterbatasan. Mereka memiliki semangat belajar yang tinggi dan membentuk kelompok yang disebut Laskar Pelangi. Cerita menggambarkan persahabatan, perjuangan dalam memperoleh pendidikan, impian, serta semangat untuk menghadapi berbagai kesulitan hidup. Dengan tokoh-tokoh yang memiliki karakter unik, novel ini menunjukkan bahwa keterbatasan ekonomi bukanlah penghalang untuk memiliki cita-cita dan meraih masa depan. Laskar Pelangi juga mengangkat pentingnya pendidikan, persahabatan, kerja keras, dan keberanian dalam mengejar impian. Novel ini menjadi karya pertama Andrea Hirata dan pertama kali diterbitkan oleh Bentang Pustaka pada tahun 2005.',
                'categories' => ['Fiksi','Sejarah'],
            ],
            
            [
                'isbn' => '9789799731234',
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'publisher' => 'Hasta Mitra',
                'published_year' => '2005',
                'description' => 'Bumi Manusia adalah novel karya Pramoedya Ananta Toer yang menjadi buku pertama dalam Tetralogi Buru. Novel ini berlatar Hindia Belanda pada awal abad ke-20 dan menceritakan kehidupan Minke, seorang pemuda pribumi yang memperoleh pendidikan Eropa dan mulai menyadari ketidakadilan serta ketimpangan sosial yang terjadi di masyarakat kolonial. Melalui kehidupan Minke, pembaca diajak melihat persoalan pendidikan, perbedaan kelas sosial, kolonialisme, diskriminasi, cinta, keluarga, serta perjuangan untuk mendapatkan kebebasan dan martabat sebagai manusia. Tokoh Nyai Ontosoroh juga menjadi salah satu tokoh penting yang menggambarkan keberanian, kemandirian, dan perlawanan terhadap sistem sosial yang menindas. Bumi Manusia tidak hanya menceritakan kisah kehidupan dan percintaan para tokohnya, tetapi juga menggambarkan kondisi masyarakat Indonesia pada masa penjajahan serta tumbuhnya kesadaran untuk melawan ketidakadilan. Novel ini merupakan bagian awal dari perjalanan Minke yang berlanjut dalam tiga novel berikutnya dalam Tetralogi Buru.',
                'categories' => ['Fiksi','Sejarah'],
            ]
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
