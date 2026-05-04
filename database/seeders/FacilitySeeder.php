<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            ['name' => 'ICU (Intensive Care Unit)', 'category' => 'Ruang Perawatan', 'description' => 'Ruang perawatan intensif dengan peralatan medis lengkap'],
            ['name' => 'Ruang Operasi', 'category' => 'Ruang Perawatan', 'description' => 'Ruang operasi modern dengan teknologi terkini'],
            ['name' => 'Farmasi', 'category' => 'Penunjang', 'description' => 'Apotek dengan persediaan obat lengkap'],
            ['name' => 'Ambulance', 'category' => 'Transportasi', 'description' => 'Layanan ambulance 24 jam'],
            ['name' => 'Parkir Luas', 'category' => 'Fasilitas Umum', 'description' => 'Area parkir yang luas dan aman'],
            ['name' => 'Musholla', 'category' => 'Fasilitas Umum', 'description' => 'Tempat ibadah yang nyaman'],
            ['name' => 'Kantin', 'category' => 'Fasilitas Umum', 'description' => 'Kantin dengan menu sehat dan bergizi'],
            ['name' => 'WiFi Gratis', 'category' => 'Fasilitas Umum', 'description' => 'Akses internet gratis untuk pasien dan pengunjung'],
        ];

        foreach ($facilities as $facility) {
            Facility::create([
                'name' => $facility['name'],
                'category' => $facility['category'],
                'description' => $facility['description'],
                'is_active' => true,
            ]);
        }
    }
}
