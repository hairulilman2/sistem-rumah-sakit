<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        // Create categories
        $categories = [
            'Kesehatan',
            'Pengumuman',
            'Kegiatan',
            'Tips Kesehatan',
        ];

        foreach ($categories as $cat) {
            NewsCategory::create([
                'name' => $cat,
                'slug' => Str::slug($cat),
            ]);
        }

        $admin = User::where('email', 'admin@rumahsakit.com')->first();
        
        $newsData = [
            ['title' => 'Tips Menjaga Kesehatan di Musim Hujan', 'category' => 'Tips Kesehatan', 'body' => 'Musim hujan telah tiba. Berikut tips menjaga kesehatan...'],
            ['title' => 'Rumah Sakit Buka Layanan Baru', 'category' => 'Pengumuman', 'body' => 'Kami dengan bangga mengumumkan pembukaan layanan baru...'],
            ['title' => 'Pentingnya Vaksinasi untuk Anak', 'category' => 'Kesehatan', 'body' => 'Vaksinasi merupakan hal penting untuk kesehatan anak...'],
            ['title' => 'Bakti Sosial Kesehatan Gratis', 'category' => 'Kegiatan', 'body' => 'Rumah sakit mengadakan bakti sosial kesehatan gratis...'],
            ['title' => 'Cara Mencegah Penyakit Jantung', 'category' => 'Tips Kesehatan', 'body' => 'Penyakit jantung dapat dicegah dengan pola hidup sehat...'],
            ['title' => 'Jadwal Dokter Spesialis Bulan Ini', 'category' => 'Pengumuman', 'body' => 'Berikut jadwal lengkap dokter spesialis bulan ini...'],
            ['title' => 'Seminar Kesehatan Mental', 'category' => 'Kegiatan', 'body' => 'Kami mengadakan seminar kesehatan mental gratis...'],
            ['title' => 'Manfaat Olahraga Teratur', 'category' => 'Tips Kesehatan', 'body' => 'Olahraga teratur memberikan banyak manfaat untuk kesehatan...'],
            ['title' => 'Peningkatan Fasilitas Rumah Sakit', 'category' => 'Pengumuman', 'body' => 'Rumah sakit terus meningkatkan fasilitas pelayanan...'],
            ['title' => 'Donor Darah Rutin', 'category' => 'Kegiatan', 'body' => 'Kegiatan donor darah rutin diadakan setiap bulan...'],
        ];

        foreach ($newsData as $news) {
            $category = NewsCategory::where('name', $news['category'])->first();
            
            News::create([
                'author_id' => $admin->id,
                'category_id' => $category->id,
                'title' => $news['title'],
                'slug' => Str::slug($news['title']),
                'excerpt' => Str::limit($news['body'], 100),
                'body' => $news['body'] . ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'status' => 'published',
                'published_at' => now()->subDays(rand(1, 30)),
            ]);
        }
    }
}
