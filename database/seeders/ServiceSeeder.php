<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['dept' => 'IGD (Instalasi Gawat Darurat)', 'name' => 'Penanganan Kecelakaan', 'price' => 'Rp 500.000 - Rp 2.000.000'],
            ['dept' => 'IGD (Instalasi Gawat Darurat)', 'name' => 'Penanganan Serangan Jantung', 'price' => 'Rp 1.000.000 - Rp 5.000.000'],
            ['dept' => 'Rawat Inap', 'name' => 'Kamar Kelas 3', 'price' => 'Rp 150.000/hari'],
            ['dept' => 'Rawat Inap', 'name' => 'Kamar Kelas 2', 'price' => 'Rp 250.000/hari'],
            ['dept' => 'Rawat Inap', 'name' => 'Kamar Kelas 1', 'price' => 'Rp 400.000/hari'],
            ['dept' => 'Rawat Inap', 'name' => 'Kamar VIP', 'price' => 'Rp 750.000/hari'],
            ['dept' => 'Poli Umum', 'name' => 'Konsultasi Dokter Umum', 'price' => 'Rp 50.000'],
            ['dept' => 'Poli Umum', 'name' => 'Pemeriksaan Kesehatan Umum', 'price' => 'Rp 100.000'],
            ['dept' => 'Poli Gigi', 'name' => 'Konsultasi Dokter Gigi', 'price' => 'Rp 75.000'],
            ['dept' => 'Poli Gigi', 'name' => 'Pembersihan Karang Gigi', 'price' => 'Rp 200.000'],
            ['dept' => 'Poli Gigi', 'name' => 'Tambal Gigi', 'price' => 'Rp 150.000 - Rp 500.000'],
            ['dept' => 'Laboratorium', 'name' => 'Pemeriksaan Darah Lengkap', 'price' => 'Rp 100.000'],
            ['dept' => 'Laboratorium', 'name' => 'Pemeriksaan Urine', 'price' => 'Rp 50.000'],
            ['dept' => 'Laboratorium', 'name' => 'Pemeriksaan Gula Darah', 'price' => 'Rp 30.000'],
            ['dept' => 'Radiologi', 'name' => 'Rontgen Thorax', 'price' => 'Rp 150.000'],
            ['dept' => 'Radiologi', 'name' => 'USG', 'price' => 'Rp 200.000 - Rp 500.000'],
        ];

        foreach ($services as $service) {
            $department = Department::where('name', $service['dept'])->first();
            
            if ($department) {
                Service::create([
                    'department_id' => $department->id,
                    'name' => $service['name'],
                    'slug' => Str::slug($service['name']),
                    'description' => 'Layanan ' . $service['name'] . ' dengan fasilitas lengkap dan tenaga medis profesional.',
                    'price_range' => $service['price'],
                    'is_active' => true,
                ]);
            }
        }
    }
}
